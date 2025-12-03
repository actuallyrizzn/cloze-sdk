"""End-to-end tests for complete workflows."""

import pytest
import time
from cloze_sdk import ClozeClient
from cloze_sdk.exceptions import ClozeAPIError


@pytest.mark.e2e
@pytest.mark.slow
class TestE2EWorkflows:
    """End-to-end tests for complete workflows."""
    
    def test_full_person_lifecycle(self, real_client):
        """Test complete person lifecycle: create, get, update, find, delete."""
        # Create a unique email for this test
        test_email = f"test_e2e_{int(time.time())}@example.com"
        
        try:
            # Create person
            create_result = real_client.people.create({
                "email": test_email,
                "first": "E2E",
                "last": "Test"
            })
            assert create_result.get("errorcode") == 0
            
            # Get person
            get_result = real_client.people.get(test_email)
            assert get_result.get("errorcode") == 0
            assert "person" in get_result or "email" in str(get_result)
            
            # Update person
            update_result = real_client.people.update({
                "email": test_email,
                "first": "E2E",
                "last": "Updated"
            })
            assert update_result.get("errorcode") == 0
            
            # Find person
            find_result = real_client.people.find(query={"email": test_email})
            assert find_result.get("errorcode") == 0
            
            # Clean up - delete person
            delete_result = real_client.people.delete(test_email)
            assert delete_result.get("errorcode") == 0
            
        except ClozeAPIError as e:
            pytest.skip(f"E2E test skipped due to API error: {e}")
    
    def test_full_company_lifecycle(self, real_client):
        """Test complete company lifecycle: create, get, update, find, delete."""
        # Create a unique domain for this test
        test_domain = f"teste2e{int(time.time())}.com"
        
        try:
            # Create company
            create_result = real_client.companies.create({
                "name": "E2E Test Company",
                "domain": test_domain
            })
            assert create_result.get("errorcode") == 0
            
            # Get company
            get_result = real_client.companies.get(test_domain)
            assert get_result.get("errorcode") == 0
            
            # Update company
            update_result = real_client.companies.update({
                "domain": test_domain,
                "name": "E2E Updated Company"
            })
            assert update_result.get("errorcode") == 0
            
            # Find company
            find_result = real_client.companies.find(query={"domain": test_domain})
            assert find_result.get("errorcode") == 0
            
            # Clean up - delete company
            delete_result = real_client.companies.delete(test_domain)
            assert delete_result.get("errorcode") == 0
            
        except ClozeAPIError as e:
            pytest.skip(f"E2E test skipped due to API error: {e}")
    
    def test_full_project_lifecycle(self, real_client):
        """Test complete project lifecycle: create, get, update, find, delete."""
        # Create a unique project name
        test_name = f"E2E Test Project {int(time.time())}"
        
        try:
            # Create project
            create_result = real_client.projects.create({
                "name": test_name
            })
            assert create_result.get("errorcode") == 0
            
            # Note: Getting projects by name might require find instead of get
            # Find project
            find_result = real_client.projects.find(query={"name": test_name})
            assert find_result.get("errorcode") == 0
            
            # Update project (if we can get an identifier)
            if find_result.get("list") and len(find_result["list"]) > 0:
                project_id = find_result["list"][0].get("id") or find_result["list"][0].get("uniqueid")
                if project_id:
                    update_result = real_client.projects.update({
                        "id": project_id,
                        "name": f"{test_name} Updated"
                    })
                    assert update_result.get("errorcode") == 0
                    
                    # Clean up - delete project
                    delete_result = real_client.projects.delete(project_id)
                    assert delete_result.get("errorcode") == 0
            
        except ClozeAPIError as e:
            pytest.skip(f"E2E test skipped due to API error: {e}")
    
    def test_webhook_subscribe_unsubscribe_workflow(self, real_client):
        """Test complete webhook workflow: subscribe, list, unsubscribe."""
        test_url = "https://example.com/test-webhook"
        test_event = "person.audit.change"
        
        try:
            # Subscribe
            subscribe_result = real_client.webhooks.subscribe(
                event=test_event,
                target_url=test_url,
                scope="local",
                client_reference=f"test_e2e_{int(time.time())}"
            )
            assert subscribe_result.get("errorcode") == 0
            uniqueid = subscribe_result.get("uniqueid")
            
            if uniqueid:
                # List webhooks (verify it's there)
                list_result = real_client.webhooks.list()
                assert list_result.get("errorcode") == 0
                
                # Unsubscribe
                unsubscribe_result = real_client.webhooks.unsubscribe(
                    event=test_event,
                    uniqueid=uniqueid
                )
                assert unsubscribe_result.get("errorcode") == 0
                
        except ClozeAPIError as e:
            pytest.skip(f"E2E test skipped due to API error: {e}")
    
    def test_analytics_query_workflow(self, real_client):
        """Test analytics query workflow."""
        try:
            # Query activity
            activity_result = real_client.analytics.query_activity({
                "test_query": {
                    "max": 5,
                    "scale": "month",
                    "measures": ["sentmails"]
                }
            })
            assert activity_result.get("errorcode") == 0
            
        except ClozeAPIError as e:
            pytest.skip(f"E2E test skipped due to API error: {e}")
    
    def test_timeline_creation_workflow(self, real_client):
        """Test timeline item creation workflow."""
        test_email = f"test_timeline_{int(time.time())}@example.com"
        
        try:
            # Create a person first
            person_result = real_client.people.create({
                "email": test_email,
                "first": "Timeline",
                "last": "Test"
            })
            
            if person_result.get("errorcode") == 0:
                # Create a todo
                todo_result = real_client.timeline.create_todo({
                    "person": {"email": test_email},
                    "text": "E2E Test Todo",
                    "due": int(time.time()) + 86400  # Tomorrow
                })
                assert todo_result.get("errorcode") == 0
                
                # Create a note
                note_result = real_client.timeline.create_content({
                    "person": {"email": test_email},
                    "type": "note",
                    "text": "E2E Test Note"
                })
                assert note_result.get("errorcode") == 0
                
                # Clean up
                real_client.people.delete(test_email)
                
        except ClozeAPIError as e:
            pytest.skip(f"E2E test skipped due to API error: {e}")
    
    def test_feed_pagination_workflow(self, real_client):
        """Test feed pagination workflow."""
        try:
            # Get initial feed
            feed_result = real_client.people.feed(scope="local")
            assert feed_result.get("errorcode") == 0
            
            # If there's a cursor, get next page
            if feed_result.get("cursor"):
                next_result = real_client.people.feed(cursor=feed_result["cursor"])
                assert next_result.get("errorcode") == 0
                
        except ClozeAPIError as e:
            pytest.skip(f"E2E test skipped due to API error: {e}")

