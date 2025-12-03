# Cloze API Documentation

> Comprehensive documentation for all Cloze API endpoints and webhooks.

## Overview

The Cloze API provides programmatic access to Cloze CRM functionality, allowing you to integrate Cloze data and features into your applications. This documentation covers all available endpoints, authentication methods, and webhook subscriptions.

### Base Information

- **Base URL:** `https://api.cloze.com`
- **API Version:** 2025.10
- **Protocol:** HTTPS only
- **Data Format:** JSON

### Authentication

The Cloze API supports three authentication methods:

1. **API Key** - Simplest method for development and testing
   - Pass as query parameter: `?api_key=YOUR_API_KEY`
   - Or as Bearer token: `Authorization: Bearer YOUR_API_KEY`

2. **OAuth 2.0** - Required for public integrations
   - Authorization URL: `https://www.cloze.com/oauth/authorize`
   - Token URL: `https://www.cloze.com/oauth/token`
   - Required scopes vary by endpoint

3. **Bearer Token** - Alternative API key format
   - Header: `Authorization: Bearer YOUR_API_KEY`

> **Note:** For public integrations intended for use by Cloze users outside your organization, you must use OAuth 2.0. Contact support@cloze.com to get started.

## Table of Contents

- [Analytics](#analytics)
- [Team](#team)
- [Account](#account)
- [Projects](#projects)
- [People](#people)
- [Companies](#companies)
- [Timeline](#timeline)
- [Webhooks](#webhooks)

---

## Analytics

The Analytics endpoints provide access to activity data, team metrics, funnel information, and lead analytics.

### POST /v1/analytics/activity

**Summary:** Query user activity

**Description:**

Query activity data for the user.  Reports on one or more of the following activity measures

- **`sentmails`**: emails sent

- **`rcvdstandard`**: emails received (non-bulk)

- **`rcvdbulk`**: bulk emails received

- **`meetings`**: meetings scheduled

- **`meetingmins`**: meeting minutes scheduled

- **`inbcalls`**: inbound voice calls

- **`inbcallmins`**: inbound voice call minutes

- **`outbcalls`**: outbound voice calls

- **`outbcallmins`**: outbound voice call minutes

- **`outbcalls_short`**: The number of outbound calls that were a short amount of time in duration

- **`outbcalls_medium`**: The number of outbound calls that were a medium amount of time in duration

- **`outbcalls_long`**: The number of minutes in outbound calls that were a long amount of time in duration

- **`outbcalls_short_mins`**: The number of minutes in outbound calls that were short in duration

- **`outbcalls_medium_mins`**: The number of minutes in outbound calls that were medium in duration

- **`outbcalls_long_mins`**: The number of minutes in outbound calls that were long in duration

- **`inbcalls_short`**: The number of inbound calls that were a short amount of time in duration

- **`inbcalls_medium`**: The number of inbound calls that were a medium amount of time in duration

- **`inbcalls_long`**: The number of inbound calls that were a long amount of time in duration

- **`inbcalls_short_mins`**: The number of minutes in inbound calls that were short in duration

- **`inbcalls_medium_mins`**: The number of minutes in inbound calls that were medium in duration

- **`inbcalls_long_mins`**: The number of minutes in inbound calls that were long in duration

- **`sentmessages`**: sent text messages

- **`rcvdmessages`**: received text messages

- **`creatednotes`**: Notes created

- **`updatednotes`**: Notes updated

- **`newtodos`**: ToDos created

- **`donetodos`**: ToDos completed

- **`donesteps`**: Steps completed

- **`mailopens`**: Email opens

Queries must specify a period scale, one of `year`, `quarter`, `month` or `week`


**Authentication:**

- OAuth 2.0 (scopes: analytics)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Parameters:**

- **`queries`** (body, **Required**): map of `Query` definitions. The response will be organized by the query names that were provided in the input map.
  - Body properties:
    - `exampleQueryName` (object): Each query in the map should have a different name. The response will be organized by the query names that were provided.

**Request Example:**

```json
{
  "queries": {
    "advisorqtr": {
      "max": 30,
      "scale": "quarter",
      "tag": "advisor",
      "measures": [
        "sentmails",
        "rcvdstandard",
        "meetings",
        "inbcalls",
        "outbcalls"
      ]
    }
  }
}
```

**Responses:**


- **`200`**: Activity data for individual reporting periods

---

### POST /v1/analytics/funnel

**Summary:** Query funnel information (BETA)

**Description:**

Query funnel information (BETA)

The following metrics are supported:

- **`leadcount`**:     The number of contacts that went into the lead stage after the start of the period

- **`currentcount`**:  The number of contacts that went into the current stage after the start of the period

- **`futurecount`**:   The number of contacts that went into the future stage after the start of the period

- **`currentcount`**:  The number of contacts that went into the current stage after the start of the period

- **`pendingcount`**:  The number of contacts that went into the pending stage after the start of the period

`woncount`     -  The number of contacts that went into the won stage after the start of the period

`lostcount`    -  The number of contacts that went into the lost stage after the start of the period

- **`stepwoncount`**:  The number of funnels that made it to the won step

- **`steplostcount`**: The number of funnels that went to the lost step

- **`period_steplostcount`**: The number of funnels that went to the lost step during the selected period

- **`stepnextcount`**: The number of funnels that went into the next step

- **`stepintocount`**: The number of funnels that stepped into a step

- **`period_stepintocount`**: The number of funnels that stepped into a step in the selected period

- **`stepcount`**: The number of funnels currently in a step

- **`averagesteptime`**: The average time in a step

- **`mediansteptime`**: The median time in a step

- **`cumulative_lead`**: The number of current open leads

- **`cumulative_current`**: The number of funnels in the current stage

- **`cumulative_future`**: The number of funnels in the future stage

- **`cumulative_pending`**: The number of funnels in the pending stage

- **`cumulative_won`**: The number of funnels in the won stage (excludes anything before the selected period)

- **`cumulative_lost`**: The number of funnels in the lost stage (excludes anything before the selected period)

- **`lead_future`**: The number of funnels that went from the lead stage to the future stage

- **`lead_lost`**: The number of funnels that went from the lead stage to the lost stage

- **`future_current`**: The number of funnels that went from the future stage to the current stage

- **`future_won`**: The number of funnels that went from the future stage to the won stage (only applicable if current/pending stages are disabled)

- **`future_lost`**: The number of funnels that went from the future stage to the lost stage

- **`current_pending`**: The number of funnels that wen from the current stage to the pending stage

- **`current_lost`**: The number of funnels that went from the current stage to the lost stage

- **`current_won`**: The number of funnels that went from the current stage to the won stage (only applicable if pending stages are disabled)

- **`pending_won`**: The number of funnels that went from the pending stage to the won stage

- **`pending_lost`**: The number of funnels that went from the pending stage to the lost stage

- **`period_lead_future`**: The number of funnels that went from the lead stage to the future stage in the selected period

- **`period_lead_lost`**: The number of funnels that went from the lead stage to the lost stage in the selected period

- **`period_future_current`**: The number of funnels that went from the future stage to the current stage in the selected period

- **`period_future_won`**: The number of funnels that went from the future stage to the won stage in the selected period (only applicable if current/pending stages are disabled)

- **`period_future_lost`**: The number of funnels that went from the future stage to the lost stage in the selected period

- **`period_current_pending`**: The number of funnels that wen from the current stage to the pending stage in the selected period

- **`period_current_lost`**: The number of funnels that went from the current stage to the lost stage in the selected period

- **`period_current_won`**: The number of funnels that went from the current stage to the won stage in the selected period (only applicable if pending stages are disabled)

- **`period_pending_won`**: The number of funnels that went from the pending stage to the won stage in the selected period

- **`period_pending_lost`**: The number of funnels that went from the pending stage to the lost stage in the selected period

- **`lead_time`**: The median time funnels have been in the lead stage in milliseconds

- **`future_time`**: The median time funnels have been in the future stag in millisecondse

- **`current_time`**: The median time funnels have been in the current stage in milliseconds

- **`pending_time`**: The median time funnels have been in the pending stage in milliseconds

- **`lead_uncombined_conversion`**: The uncombined conversion of the lead stage

- **`future_uncombined_conversion`**: The uncombined conversion of the future stage

- **`current_uncombined_conversion`**: The uncombined conversion of the current stage

- **`pending_uncombined_conversion`**: The uncombined conversion of the pending stage

- **`won_uncombined_conversion`**: The uncombined conversion of the won stage

- **`lead_combined_conversion`**: The combined conversion of the lead stage

- **`future_combined_conversion`**: The combined conversion of the future stage

- **`current_combined_conversion`**: The combined conversion of the current stage

- **`pending_combined_conversion`**: The combined conversion of the pending stage

- **`won_combined_conversion`**: The combined conversion of the won stage

- **`step_uncombined_conversion`**: The per-step uncombined conversion

- **`step_combined_conversion`**: The per-step combined conversion

- **`cumulative_steplostcount`**: The total number of funnels that went to lost before a step

- **`cumulative_period_steplostcount`**:  The total number of funnels that went to lost before a step, only during the selected period

- **`cumulative_mediansteptime`**: The median step time of all steps before a step

- **`cumulative_period_mediansteptime`**: The median step time of all steps before a step, only during the selected period

- **`stepintolostcount`**: The number of funnels that went to lost from the pervious step to the current step

- **`period_stepintolostcount`**: The number of funnels that went to lost from the pervious step to the current step, only during the selected period

- **`lasttouch`**: The last time a funnel had a touch activity as a timestamp

- **`lastactivity`**: The last time a funnel had any activity as a timestamp

- **`lastengagement`**: The last time a funnel had a engagement activity as a timestamp

- **`average_touches`**: The average number of touches

- **`sentmails`**: The number of emails sent

- **`rcvdstandard`**: The number of emails received (non-bulk)

- **`rcvdbulk`**: The number of emails received (bulk)

- **`mailopens`**: The number of mail opens 

- **`sentmessages`**: The number of sent text messages 

- **`rcvdmessages`**: The number of recieved text messages

- **`remails`**: emails referenced

- **`touch`**: The number of touches

- **`postalbulk`**: The number of bulk postal mail

- **`postalstd`**: The number of non-bulk postal mail

- **`engagement`**: The number of engagments

- **`mailclicks`**: The number of mailclicls

- **`mailreplies`**: The number of mail replies

- **`dropins`**: The number of drop ins

- **`meetings`**: The number of meetings 

- **`recalls`**: The number of referened calls 

- **`outbcalls`**: The number of outbound calls 

- **`inbcalls`**: The number of inbound calls 

- **`remessages`**: The number of referenced text messages

- **`creatednotes`**: The number of notes created

- **`donetodos`**: The number of todos done 

- **`newtodos`**: The number of todos created 

- **`donesteps`**: The number of steps done 

- **`dropinmins`**: The number of minutes for dropins

- **`meetingmins`**: The number of minutes for meetings

- **`recallmins`**: The number of minures for referenced calls

- **`outbcallmins`**: The number of minitues in outbound calls

- **`inbcallmins`**: The number of minutes in inbound calls

- **`outbcalls_short`**: The number of outbound calls that were a short amount of time in duration

- **`outbcalls_medium`**: The number of outbound calls that were a medium amount of time in duration

- **`outbcalls_long`**: The number of minutes in outbound calls that were a long amount of time in duration

- **`outbcalls_short_mins`**: The number of minutes in outbound calls that were short in duration

- **`outbcalls_medium_mins`**: The number of minutes in outbound calls that were medium in duration

- **`outbcalls_long_mins`**: The number of minutes in outbound calls that were long in duration

- **`inbcalls_short`**: The number of inbound calls that were a short amount of time in duration

- **`inbcalls_medium`**: The number of inbound calls that were a medium amount of time in duration

- **`inbcalls_long`**: The number of inbound calls that were a long amount of time in duration

- **`inbcalls_short_mins`**: The number of minutes in inbound calls that were short in duration

- **`inbcalls_medium_mins`**: The number of minutes in inbound calls that were medium in duration

- **`inbcalls_long_mins`**: The number of minutes in inbound calls that were long in duration

- **`outreach`**: The number of emails, texts, and calls to unique people per day

- **`engagement`**: The number of meetings with or emails, texts, and calls from unique people per day

- **`interaction`**: The number of emails, texts, calls, and meetings with unique people per day

Configured Measures can be queried using "#measure-name".


**Authentication:**

- OAuth 2.0 (scopes: analytics)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Parameters:**

- **`usertags`** (body, Optional): Array of user tags to filter users
- **`queries`** (body, **Required**): map of `Query` definitions. The response will be organized by the query names that were provided in the input map.
  - Body properties:
    - `exampleQueryName` (object): Each query in the map should have a different name. The response will be organized by the query names that were provided.

**Responses:**


- **`200`**: Lead Qualification Data

---

### POST /v1/analytics/leads

**Summary:** Query lead qualification data

**Description:**

Query lead qualification data


**Authentication:**

- OAuth 2.0 (scopes: analytics)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Parameters:**

- **`queries`** (body, **Required**): map of `Query` definitions. The response will be organized by the query names that were provided in the input map.
  - Body properties:
    - `exampleQueryName` (object): Each query in the map should have a different name. The response will be organized by the query names that were provided.

**Responses:**


- **`200`**: Lead Qualification Data

---

### POST /v1/analytics/projects

**Summary:** Query project data

**Description:**

Query for data about projects/deals that are active or in the pipeline.  You can select projects according to where
their start, active and end dates fall relative to a reporting period, and retrieve various metrics for each.
###Reporting Period
The`scale` property controls what type of reporting period you want to query - the current `year`, `quarter`, or `month`.

The `relative` property allows you to retrieve future periods, by setting e.g. `relative:0` for the current
period, `relative:1` for the next, and so on.  If not set it defaults to `relative:0`
###Metrics
The following metrics are available about each project

- **`segment`**: the segment the project belongs to

- **`stage`**: the stage the project is in

- **`meta_value`**: the financial value of the project

- **`project_start`**: UTC ms timestamp of the project start date

- **`project_active`**: UTC ms timestamp of the project active date

- **`project_end`**: UTC ms timestamp of the project end date


**Authentication:**

- OAuth 2.0 (scopes: analytics)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Parameters:**

- **`queries`** (body, **Required**): Map of `ProjectQuery` definitions. The response will be organized by the query names that were provided in the input map.
  - Body properties:
    - `mode` (string): one of `pipeline` or `active` (default is pipeline)
    - `exampleQueryName` (object): Each query in the map should have a different name. The response will be organized by the query names that were provided.

**Request Example:**

```json
{
  "queries": {
    "dealsqtr": {
      "mode": "pipeline",
      "always": "in-period",
      "scale": "quarter",
      "relative": 0,
      "metrics": [
        "stage",
        "segment",
        "nextstep",
        "meta_value",
        "project_start",
        "project_end"
      ]
    }
  }
}
```

**Responses:**


- **`200`**: Pipeline data

---

### POST /v1/analytics/teamactivity

**Summary:** Query team activity

**Description:**

Query activity data for the user's team.  Reports activity for a particular period across one or
more of the following measures

- **`sentmails`**: emails sent

- **`rcvdstandard`**: emails received (non-bulk)

- **`rcvdbulk`**: bulk emails received

- **`meetings`**: meetings scheduled

- **`meetingmins`**: meeting minutes scheduled

- **`inbcalls`**: inbound voice calls

- **`inbcallmins`**: inbound voice call minutes

- **`outbcalls`**: outbound voice calls

- **`outbcallmins`**: outbound voice call minutes

- **`outbcalls_short`**: The number of outbound calls that were a short amount of time in duration

- **`outbcalls_medium`**: The number of outbound calls that were a medium amount of time in duration

- **`outbcalls_long`**: The number of minutes in outbound calls that were a long amount of time in duration

- **`outbcalls_short_mins`**: The number of minutes in outbound calls that were short in duration

- **`outbcalls_medium_mins`**: The number of minutes in outbound calls that were medium in duration

- **`outbcalls_long_mins`**: The number of minutes in outbound calls that were long in duration

- **`inbcalls_short`**: The number of inbound calls that were a short amount of time in duration

- **`inbcalls_medium`**: The number of inbound calls that were a medium amount of time in duration

- **`inbcalls_long`**: The number of inbound calls that were a long amount of time in duration

- **`inbcalls_short_mins`**: The number of minutes in inbound calls that were short in duration

- **`inbcalls_medium_mins`**: The number of minutes in inbound calls that were medium in duration

- **`inbcalls_long_mins`**: The number of minutes in inbound calls that were long in duration

- **`sentmessages`**: sent text messages

- **`rcvdmessages`**: received text messages

- **`creatednotes`**: Notes created

- **`updatednotes`**: Notes updated

- **`newtodos`**: ToDos created

- **`donetodos`**: ToDos completed

- **`donesteps`**: Steps completed

- **`mailopens`**: Email opens

- **`meta_value`**: The pipeline value

Queries must specify a period scale, one of `year`, `quarter`, `month` or `week`


**Authentication:**

- OAuth 2.0 (scopes: analytics)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Parameters:**

- **`queries`** (body, **Required**): map of `Query` definitions. The response will be organized by the query names that were provided in the input map.
  - Body properties:
    - `exampleQueryName` (object): Each query in the map should have a different name. The response will be organized by the query names that were provided.

**Request Example:**

```json
{
  "queries": {
    "advisorqtr": {
      "max": 30,
      "scale": "quarter",
      "tag": "advisor",
      "measures": [
        "sentmails",
        "rcvdstandard",
        "meetings",
        "inbcalls",
        "outbcalls"
      ]
    }
  }
}
```

**Responses:**


- **`200`**: Activity data

---

### GET /v1/analytics/teamactivity/update

**Summary:** Update team activity

**Description:**

Update team activity for one or more team members. Note that calling this more frequently than every 15 minutes will result in updates being skipped.


**Authentication:**

- OAuth 2.0 (scopes: analytics)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Parameters:**

- **`tag`** (query, Optional): Tag that identifies which team members to update
- **`wait`** (query, Optional): Amount of time (in ms) to wait for update to complete (default is 1 minute)
- **`skip`** (query, Optional): Do not start an update, just return the most recent update date

**Responses:**


- **`200`**: Date range of updates

---

---

## Team

Endpoints for managing team members, roles, and organizational structure.

### GET /v1/team/members/list

**Summary:** Get team members

**Description:**

Get a list of the members of the user's current team.

Requires View User and Edit Team permissions


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Members

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "list": [
      {
        "name": "Dave Varenos",
        "email": "dave@incfire.com"
      },
      {
        "name": "Dana Varenos",
        "email": "dana@incfire.com"
      }
    ]
  }
  ```

---

### POST /v1/team/members/update

**Summary:** Update team member

**Description:**

Update the subteam node, user profile custom fields, and user profile keywords of a team member.  Requires
View User and Edit Team permissions


**Authentication:**

- OAuth 2.0 (scopes: change_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`teammember`** (body, Optional): settings for this team member user
  - Body properties:
    - `key` (string): the team member's user account email
    - `role` (string): the role label of the role to be applied to the team member
    - `node` (string): the subteam node to be applied to the team member
    - `nodeByParts` (array): the subteam node to be applied to the team member, as an array of node path elements.
    - `secondaryNodes` (array): the additional nodes the team member can see; removes any previous secondary nodes
    - `visibleAt` (array): the additional nodes where the team member can be found; removes any previous visibleAt nodes
    - `customFields` (object): array of custom fields to set in the member's personal profile
    - `keywords` (object): arrays of keywords (aka tags) to be added or removed

**Request Example:**

```json
{
  "key": "dana@incfire.com",
  "customFields": [
    {
      "id": "acme-mls-id",
      "name": "Acme MlsId",
      "value": "123456"
    }
  ],
  "keywords": {
    "add": [
      "osa",
      "onboard"
    ],
    "remove": [
      "isa"
    ]
  }
}
```

**Responses:**


- **`200`**: Error Response

---

### GET /v1/team/nodes

**Summary:** Get subteam nodes

**Description:**

Get a list of the currently defined subteam nodes within the team

Requires View User and Edit Team permissions


**Authentication:**

- OAuth 2.0 (scopes: basic)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: an error code a a list of node information items

---

### GET /v1/team/roles

**Summary:** Get team roles

**Description:**

Get a list of the defined roles in a team

Requires View User and Edit Team permissions


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: an error code a a list of the names and ids for the roles

---

---

## Account

Endpoints for retrieving user account information, custom fields, stages, segments, steps, and views.

### GET /v1/user/fields

**Summary:** Get custom fields

**Description:**

Get custom fields for the user. By default all custom fields are retrieved. An optional *relationtype* query parameter
may be specified: one of *person*, *project* and *company* this returns custom field meta-data that apply to the specific relation type.
Please refer to samples for further information.


**Authentication:**

- OAuth 2.0 (scopes: basic)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Parameters:**

- **`relationtype`** (query, Optional): person, project, or company or empty for all relation type customizations
  - Allowed values: `person`, `project`, `company`

**Responses:**


- **`200`**: Custom fields

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "list": [
      {
        "id": "role",
        "type": "keyword",
        "name": "Role",
        "description": "Role of a person in their business",
        "relations": {
          "person": true
        },
        "values": {
          "cxo": {
            "locked": true,
            "label": "CxO"
          },
          "vp": {
            "locked": true,
            "label": "VO"
          }
        }
      },
      {
        "id": "meeting-limit",
        "type": "number",
        "name": "Meeting Limit",
        "description": "Cap on meeting size"
      },
      {
        "id": "tweet-of-the-day",
        "type": "text",
        "name": "Tweet of the Day",
        "segments": {
          "friend": true,
          "family": true
        }
      }
    ]
  }
  ```

---

### GET /v1/user/profile

**Summary:** Get user profile

**Description:**

This API returns information about the user account that has been authorized. You can use this to personalize your app to the user, or to verify the correct user account was connected.


**Authentication:**

- OAuth 2.0 (scopes: basic)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: User profile

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "user": {
      "email": "someone@company.com",
      "name": "John Q. Public",
      "first": "John",
      "last": "Public",
      "country": "US"
    }
  }
  ```

---

### GET /v1/user/segments/people

**Summary:** Get contact segments

**Description:**

Get the people and company contact segments available within a cloze user account..


**Authentication:**

- OAuth 2.0 (scopes: basic)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Stages

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "list": [
      {
        "name": "Client",
        "key": "customer"
      },
      {
        "name": "Partners",
        "key": "partner"
      },
      {
        "name": "Suppliers",
        "key": "supplier"
      },
      {
        "name": "Investor",
        "key": "investor"
      },
      {
        "name": "Advisors",
        "key": "advisor"
      },
      {
        "name": "Buyers",
        "key": "custom1"
      }
    ]
  }
  ```

---

### GET /v1/user/segments/projects

**Summary:** Get project segments

**Description:**

Get the project segments available within a cloze user account..


**Authentication:**

- OAuth 2.0 (scopes: basic)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Stages

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "list": [
      {
        "name": "Deals",
        "key": "-project"
      },
      {
        "name": "Purchases",
        "key": "-project1"
      }
    ]
  }
  ```

---

### GET /v1/user/stages/people

**Summary:** Get people and company contact stages

**Description:**

Get the Cloze stages that apply to people and company contacts. Returns the internal Cloze stage
keys along with their user custom label.


**Authentication:**

- OAuth 2.0 (scopes: basic)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Stages

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "list": [
      {
        "name": "Lead",
        "key": "lead"
      },
      {
        "name": "Lost",
        "key": "out"
      },
      {
        "name": "Potential",
        "key": "future"
      },
      {
        "name": "Active",
        "key": "current"
      },
      {
        "name": "Inctive",
        "key": "past"
      }
    ]
  }
  ```

---

### GET /v1/user/stages/projects

**Summary:** Get project stages

**Description:**

Get the Cloze stages that apply to projects. Returns the internal Cloze project stage
keys along with their user custom label.


**Authentication:**

- OAuth 2.0 (scopes: basic)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Stages

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "list": [
      {
        "name": "Potential",
        "key": "future"
      },
      {
        "name": "Active",
        "key": "current"
      },
      {
        "name": "Done",
        "key": "won"
      },
      {
        "name": "Lost",
        "key": "lost"
      }
    ]
  }
  ```

---

### GET /v1/user/steps

**Summary:** Get steps

**Description:**

For segments, and stages within each segment, retrieve the steps available for a cloze user account.
Optional query parameters may constrain the results by segment, or by segment and stage.
Steps are returned as user labels and in Cloze internal step name format.


**Authentication:**

- OAuth 2.0 (scopes: basic)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Parameters:**

- **`segment`** (query, Optional): optional segment name
- **`stage`** (query, Optional): optional stage name, requires segment parameter to be provided if set

**Responses:**


- **`200`**: Steps

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "segments": {
      "supplier": {
        "current": {
          "steps": [
            {
              "name": "append samples",
              "key": "s-00000"
            },
            {
              "name": "have dinner with the boss",
              "key": "*s-15344457035"
            }
          ]
        }
      }
    }
  }
  ```

---

### GET /v1/user/views

**Summary:** Get views and audiences

**Description:**

Get the set of views and audiences that apply to people, companies, and projects. Under the
covers audiences and views are equivalent, but the term audience is used for people and view for
companies and projects.


**Authentication:**

- OAuth 2.0 (scopes: basic)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Views

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "people": {
      "label": {
        "singular": "Audience",
        "plural": "Audiences"
      },
      "views": [
        {
          "id": "my",
          "name": "My People"
        },
        {
          "id": "focus",
          "name": "My Network"
        }
      ]
    },
    "companies": {
      "label": {
        "singular": "View",
        "plural": "Views"
      },
      "views": [
        {
          "id": "my",
          "name": "My Companies"
        },
        {
          "id": "focus",
          "name": "My Focus"
        }
      ]
    },
    "projects": {
      "label": {
        "singular": "View",
        "plural": "Views"
      },
      "views": [
        {
          "id": "my",
          "name": "My Properties"
        },
        {
          "id": "focus",
          "name": "My Focus"
        }
      ]
    }
  }
  ```

---

---

## Projects

Endpoints for creating, updating, retrieving, and managing project/deal records.

### POST /v1/projects/create

**Summary:** Create project

**Description:**

Create a new project or merge updates into an existing one. Projects require a name.


**Authentication:**

- OAuth 2.0 (scopes: change_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`project`** (body, Optional): The project or deal to create

**Responses:**


- **`200`**: Error Response

---

### DELETE /v1/projects/delete

**Summary:** Delete project

**Description:**

Delete project based on a unique identifier, for example, twitter, email address or direct identifier


**Authentication:**

- OAuth 2.0 (scopes: change_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Delete project response

---

### GET /v1/projects/feed

**Summary:** Projects feed

**Description:**

Designed for bulk-retrieval of project records, supports an initial bulk retrieval of project records,
followed by an option to retrieve records as changes and new records occur over time.

Whilst the feed API permit records to be constrained by stage and segment, for more sophistic find capabilities
the find APIs may be used.

Provides option to return audit change records that have occurred since the person was last delivered
by the feed API.

The API operates in a cursored mode of operation in much the same way as you would use a cursor on a traditional database.
The cursor provides a consistent approach to retrieval during initial retrieval and thereafter following
changes over time.

This endpoints supports the major query(segment, stage) and scope(team etc) parameters. Records are always
returned in ascending order of last change time.

For the stream projects feed endpoint, a `cursor` will be set in all non-error responses.  Use this to retrieve
the next batch of records by passing this in the _cursor_ query parameter of the next request. Don't forget to add
any required API keys and user identification to the request. In streaming mode, API clients should handle
the case that occurs after the initial or afterwards where the stream is quiet and no records are available.
In all cases, use the returned _cursor_ to form the next request and implement suitable polling
to receive new records as changes occur.


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Projects

---

### GET /v1/projects/find

**Summary:** Find projects

**Description:**

Find projects

This endpoint supports extensive query, sort and group by options.

Either full project records or project best identifiers can be returned.

The API supports a `paged` mode of operation: the `pagenumber` parameter specifies the  page to retrieve,
`pagesize` specifies the page size.

To assist in paged retrievals, the query parameter `countonly` may be set. This returns a count of all matching
project records in a `availablecount` response property. No project records are returned in this case. Only `availablecount`
and `errorcode` are returned in the response.


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Projects

  **Example Response:**

  ```json
  {
    "Sample 1 Response to a countonly query": {
      "errorcode": 0,
      "availablecount": 6577
    },
    "Sample 2 Response to a regular query": {
      "errorcode": 0,
      "availablecount": 1,
      "pagenumber": 1,
      "pagesize": 20,
      "projects": [
        {
          "name": "School Placement",
          "node": "/US/West/CA",
          "direct": "JDTiwJTnmBPHANAgHELBAA",
          "segment": "project",
          "stage": "current"
        },
        "etc etc"
      ]
    }
  }
  ```

---

### GET /v1/projects/get

**Summary:** Get project

**Description:**

Get project based on a unique identifier, for example, twitter, email address or direct identifier


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: project

---

### POST /v1/projects/update

**Summary:** Update project

**Description:**

Merge updates into an existing project. Projects require a name.


**Authentication:**

- OAuth 2.0 (scopes: change_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`project`** (body, Optional): The project or deal updates

**Request Example:**

```json
{
  "name": "Meadow Brook Renovation",
  "summary": "Located at 33 Meadow Brook Lane",
  "stage": "future",
  "segment": "project",
  "createdDate": "2018-04-10",
  "customFields": [
    {
      "id": "value",
      "type": "currency",
      "value": 15000
    }
  ],
  "appLinks": [
    {
      "source": "na16.salesforce.com",
      "uniqueid": "006j000000Pkp1d",
      "label": "Salesforce Opportunity",
      "url": "https://na16.salesforce.com/006j000000Pkp1d"
    }
  ]
}
```

**Responses:**


- **`200`**: Error Response

---

---

## People

Endpoints for creating, updating, retrieving, and managing person/contact records.

### POST /v1/people/create

**Summary:** Create person

**Description:**

Create a new or enhance an existing person within Cloze. People can be created with just an email address or both a name and another unique identifier such as a mobile phone number, twitter handle, or facebook id.  People may be shared to the team by setting `shareTo` in the request body to `team`.


**Authentication:**

- OAuth 2.0 (scopes: change_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`person`** (body, Optional): The person

**Responses:**


- **`200`**: Error Response

---

### DELETE /v1/people/delete

**Summary:** Delete person

**Description:**

Delete person based on a unique identifier, for exanple, email, social identifier


**Authentication:**

- OAuth 2.0 (scopes: change_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Person

---

### GET /v1/people/feed

**Summary:** People feed

**Description:**

Designed for bulk-retrieval of person records, supports an initial bulk retrieval of person records,
followed by an option to retrieve records as changes and new records occur over time.

Whilst the feed API permit records to be constrained by stage and segment, for more sophisticated find capabilities
the find APIs may be used.

Provides option to return audit change records that have occurred since the person was last delivered
by the feed API.

The API operates in a cursored mode of operation in much the same way as you would use a cursor on a traditional database.
The cursor provides a consistent approach to retrieval during initial retrieval and thereafter following
changes over time.

This endpoints supports the major query(segment, stage) and scope(team etc) parameters. Records are always
returned in ascending order of last change time.

For the stream people feed endpoint, a `cursor` will be set in all non-error responses.  Use this to retrieve
the next batch of records by passing this in the _cursor_ query parameter of the next request. Don't forget to add
any required API keys and user identification to the request. In streaming mode, API clients should handle
the case that occurs after the initial or afterwards where the stream is quiet and no records are available.
In all cases, use the returned _cursor_ to form the next request and implement suitable polling
to receive new records as changes occur.


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: People

  **Example Response:**

  ```json
  {
    "Sample 1 Response to a countonly query": {
      "errorcode": 0,
      "availablecount": 6577
    },
    "Sample 2 Response to regular query": {
      "errorcode": 0,
      "availablecount": 13,
      "cursor": "cGFnZXNpemU9MiZzdGFnZT1hY3RpdmUmc2VnbWVudD1jdXN0b21lciZzdW1tYXJ5b25seT10cnVlJnN0YW1wPTE1NDQ5OTk4MTc3MzAma2V5PXVvWUJ0WGJXdmFEYWx3ME1ROUdpWmVpSUFmcTdSRk41cHcwTUVVam9PM0Emc3RhbXA9MTU0NTE2ODQwODI3MCZrZXk9dW9ZQnRYYld2YURhbHcwTVE5R2laWlgtdUtmdklmeENvZFVhV043LUxKZw",
      "people": [
        {
          "name": "Abby Vine",
          "first": "Abby",
          "last": "Vine",
          "direct": "ZoimOMrw8VfpDFr6ESegyQ",
          "segment": "custom2",
          "stage": "current",
          "step": "*s-14409658066",
          "customFields": [
            {
              "id": "words-of-wisdom",
              "type": "text",
              "value": "Stay calm"
            }
          ]
        },
        {
          "name": "Grape Vine",
          "first": "Grape",
          "last": "Vine",
          "segment": "custom2",
          "stage": "current"
        },
        "etc etc"
      ]
    },
    "Sample 3 Response to includeauditedchanges query": {
      "errorcode": 0,
      "availablecount": 13,
      "cursor": "cGFnZXNpemU9MiZzdGFnZT1hY3RpdmUmc2VnbWVudD1jdXN0b21lciZzdW1tYXJ5b25seT10cnVlJnN0YW1wPTE1NDQ5OTk4MTc3MzAma2V5PXVvWUJ0WGJXdmFEYWx3ME1ROUdpWmVpSUFmcTdSRk41cHcwTUVVam9PM0Emc3RhbXA9MTU0NTE2ODQwODI3MCZrZXk9dW9ZQnRYYld2YURhbHcwTVE5R2laWlgtdUtmdklmeENvZFVhV043LUxKZw",
      "results": [
        {
          "person": {
            "name": "Basil Brush",
            "first": "Basil",
            "last": "Brush",
            "direct": "ZoimOMrw8VfpDFr6ESegyQ",
            "segment": "custom2",
            "stage": "current",
            "customFields": [
              {
                "id": "words-of-wisdom",
                "type": "text",
                "value": "Stay calm"
              }
            ]
          },
          "changes": {
            "segment": {
              "before": "none",
              "after": "custom2"
            },
            "words-of-wisdom": {
              "before": "Dont Panic",
              "after": "Stay calm"
            },
            "_since": 548888912852
          }
        },
        {
          "person": {
            "name": "Grape Vine",
            "first": "Grape",
            "last": "Vine",
            "segment": "custom2",
            "stage": "current"
          },
          "changes": "etc etc"
        }
      ]
    }
  }
  ```

---

### GET /v1/people/find

**Summary:** Find people

**Description:**

Find people.

This endpoint supports extensive query, sort and group by options.

Either full person records or person best identifiers can be returned.

The API supports a `paged` mode of operation: the `pagenumber` parameter specifies the  page to retrieve,
`pagesize` specifies the page size.

To assist in paged retrievals, the query parameter `countonly` may be set. This returns a count of all matching
person records in a `availablecount` response property. No person records are returned in this case. Only `availablecount`
and `errorcode` are returned in the response.


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: People

  **Example Response:**

  ```json
  {
    "Sample 1 Response to a countonly query": {
      "errorcode": 0,
      "availablecount": 6577
    },
    "Sample 2 Response to regular query": {
      "errorcode": 0,
      "availablecount": 13,
      "people": [
        {
          "name": "Abby Vine",
          "first": "Abby",
          "last": "Vine",
          "direct": "ZoimOMrw8VfpDFr6ESegyQ",
          "segment": "custom2",
          "stage": "current",
          "step": "*s-14409658066",
          "customFields": [
            {
              "id": "words-of-wisdom",
              "type": "text",
              "value": "Stay calm"
            }
          ]
        },
        {
          "name": "Grape Vine",
          "first": "Grape",
          "last": "Vine",
          "segment": "custom2",
          "stage": "current"
        },
        "etc etc"
      ]
    }
  }
  ```

---

### GET /v1/people/get

**Summary:** Get person

**Description:**

Get person based on a unique identifier, for example, email, social identifier


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Person

---

### POST /v1/people/update

**Summary:** Update person

**Description:**

Enhance an existing person within Cloze. People can be referenced with just an email address or both a name and another unique identifier such as a mobile phone number, twitter handle, or facebook id.  People may be shared to the team by setting `shareTo` in the request body to `team`.


**Authentication:**

- OAuth 2.0 (scopes: change_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`person`** (body, Optional): The person

**Responses:**


- **`200`**: Error Response

---

---

## Companies

Endpoints for creating, updating, retrieving, and managing company records.

### POST /v1/companies/create

**Summary:** Create company

**Description:**

Create a new company or enhance an existing company within Cloze. Companies can be created with just a domain name or both a name and another unique identifier such as a phone number and email address. Companies may be shared to the team by setting `shareTo` in the request body to `team`.


**Authentication:**

- OAuth 2.0 (scopes: change_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`company`** (body, Optional): The company to create.

**Responses:**


- **`200`**: Error Response

---

### DELETE /v1/companies/delete

**Summary:** Delete company

**Description:**

Delete company based on a unique identifier, for example domain name, twitter, email address or direct identifier


**Authentication:**

- OAuth 2.0 (scopes: change_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Delete company response

---

### GET /v1/companies/feed

**Summary:** Companies feed

**Description:**

Designed for bulk-retrieval of company records, supports an initial bulk retrieval of company records,
followed by an option to retrieve records as changes and new records occur over time.

Whilst the feed API permit records to be constrained by stage and segment, for more sophisticated find capabilities
the find APIs may be used.

Provides option to return audit change records that have occurred since the person was last delivered
by the feed API.

The API operates in a cursored mode of operation in much the same way as you would use a cursor on a traditional database.
The cursor provides a consistent approach to retrieval during initial retrieval and thereafter following
changes over time.

This endpoint supports the major query(segment, stage, step) and scope(team etc) parameters. Records are always
returned in ascending order of last change time.

For the stream companies feed endpoint, a `cursor` will be set in all non-error responses.  Use this to retrieve
the next batch of records by passing this in the _cursor_ query parameter of the next request. Don't forget to add
any required API keys and user identification to the request. In streaming mode, API clients should handle
the case that occurs after the initial or afterwards where the stream is quiet and no records are available.
In all cases, use the returned _cursor_ to form the next request and implement suitable polling
to receive new records as changes occur.


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Companies

---

### GET /v1/companies/find

**Summary:** Find companies

**Description:**

Find companies.

This endpoint supports extensive query, sort and group by options.

Either full person records or person best identifiers can be returned.

The API supports a `paged` mode of operation: the `pagenumber` parameter specifies the  page to retrieve,
`pagesize` specifies the page size.

To assist in paged retrievals, the query parameter `countonly` may be set. This returns a count of all matching
company records in a `availablecount` response property. No company records are returned in this case. Only `availablecount`
and `errorcode` are returned in the response.


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Companies

---

### GET /v1/companies/get

**Summary:** Get company

**Description:**

Get company based on a unique identifier, for example domain name, twitter, email address or direct identifier


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Company

---

### POST /v1/companies/update

**Summary:** Update company

**Description:**

Enhance an existing company within Cloze. Companies can be referenced with just a domain name or both a name and another unique identifier such as a phone number and email address. Companies may be shared to the team by setting `shareTo` in the request body to `team`.


**Authentication:**

- OAuth 2.0 (scopes: change_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`company`** (body, Optional): The company to update.

**Request Example:**

```json
{
  "name": "IncFire Studios",
  "description": "Marketing videos made awesome!",
  "stage": "lead",
  "segment": "customer",
  "domains": [
    "incfire.com"
  ],
  "customFields": [
    {
      "id": "lead-source",
      "type": "keywords",
      "value": "comdex2018"
    }
  ]
}
```

**Responses:**


- **`200`**: Error Response

---

---

## Timeline

Endpoints for creating timeline items (communications, content, todos) and retrieving message analytics.

### GET /v1/messages/opens

**Summary:** Retrieve email opens

**Description:**

The first time you call the API, you can call it with only `user` and `api_key`. Each time you call it the API will return whether there are more results. If so, `more` will be `true` and you can use the `next` URL to retrieve the next batch of results. If you later want to call the API again, you should set the `from` query parameter to retrieve opens for a subset of messages. For example, to retrieve opens on messages sent within the last 30 days you could compute the value of the `from` parameter in Javascript with `new Date().getTime() - 1000*60*60*24*30`.


**Authentication:**

- OAuth 2.0 (scopes: read_content)
- Bearer token (API key)
- API Key (query parameter or header)

**Response Content-Type:** application/json

**Parameters:**

- **`from`** (query, Optional): UTC ms timestamp for first message to retrieve

**Responses:**


- **`200`**: Messages with opens

---

### POST /v1/timeline/communication/create

**Summary:** Add a communication record

**Description:**

This API allows you to add a new call, text, meeting, email, or direct message to Cloze


**Authentication:**

- OAuth 2.0 (scopes: change_content)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`communication`** (body, Optional): The communication record to create
  - Body properties:
    - `account` (string): Team administrators can use this to create the communication record in a different team member's account. This should be the email address of the team member. The user must be an administrator and have permission to import team data to do this.
    - `date` (['string', 'number']): when the communcation actually happened (or when the meeting is scheduled for) Can be a string or a UTC timestamp in ms since the epoch.
    - `name` (string): the from name for this communication record (the name of the person initating the communication). Alternatively, the name can be provided as a recipient with role "from" (but only one from name can be specified).
    - `from` (string): the from address for this communication record (the address of the person initating the communication). This can be an email address, phone number, social handle or app link  (e.g. na16.salesforce.com:006j000000Pkp1d). Alternatively, the from address can be provided as a recipient with role "from" (but only one from can be specified)
    - `style` (string): Style of this communication (This controls both how it will be displayed in Cloze as well has how it will be analyzed for relationship scoring).
      - Allowed values: `email`, `call`, `text`, `meeting`, `direct`, `postal`, `postal-bulk`
    - `threadid` (string): A unique identifier describing the thread this belongs to. All messages with this same threadid will be threaded together in cloze. An example of a good threadid would be a unique support ticket number.
    - `recipients` (array): Array of recipients of the communication (or attendees of calls or meetings). These must be people only (they cannot be companies or projects).
    - `references` (array): Array of people, companies, or projects related to the communication record.
    - `subject` (string): Subject of the communication record
    - `preview` (string): Preview of the body (if not provided will be automatically created from the body). Must be no longer than 1kb.
    - `body` (string): Body text of the communication record
    - `bodytype` (string): Type of the body. If not specified body is treated as plain text.
      - Allowed values: `html`, `text`
    - `due` (['string', 'number']): date stamp for reminder (1 if "someday"). Can be a string or a UTC timestamp in ms since the epoch. If not provided the reminder is treated as "someday".
    - `duration` (number): For meetings and calls, this is the duration (in minutes)
    - `location` (string): For meetings, this is the location of the meeting
    - `outcome` (string): For calls, this is the outcome
      - Allowed values: `leftvm`, `noanwser`, `connected`
    - `direction` (string): For calls and texts, this is the direction of the call
      - Allowed values: `inbound`, `outbound`
    - `measureas` (string): Classify the communication as the specified measure, e.g. "inquiry"
    - `update` (boolean): Update the existing communication record if it's already been imported
    - `links` (array): Array of links to include with this communication
    - `campaignId` (string): Trigger the campaign matching this ID on the from person if there is one
    - `dateFormat` (string): For dates of the form 1/2/2021, this determines if they are parsed as US (month/day/year) or International (day/month/year) dates.
      - Allowed values: `us`, `international`
    - `dryrun` (boolean): Run all validation but do not create/update the record
    - `skipImport` (boolean): Entirely ignore the record (do not validate, create, or update the record)

**Request Example:**

```json
{
  "date": "2018-11-20T11:45:13Z",
  "style": "call",
  "from": "+1 650-555-1212",
  "subject": "Call with Dana Varenos",
  "recipients": [
    {
      "value": "+1 781-555-1212"
    }
  ],
  "outcome": "connected",
  "duration": 12
}
```

**Responses:**


- **`200`**: Error Response

---

### POST /v1/timeline/content/create

**Summary:** Add a content record

**Description:**

This API allows you to add a new event, note, or external to do to Cloze


**Authentication:**

- OAuth 2.0 (scopes: change_content)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`content`** (body, Optional): The content record to create
  - Body properties:
    - `account` (string): Team administrators can use this to create the content in a different team member's account. This should be the email address of the team member. The user must be an administrator and have permission to import team data to do this.
    - `sendtoteam` (boolean): Use this field to place content in the local account then send it to the team account. The user must have permission to import team data to do this.
    - `date` (['string', 'number']): when the content should show up in the timeline. Can be a string or a UTC timestamp in ms since the epoch.
    - `name` (string): the from name for this content record (the name of the person that created the content record)
    - `from` (string): the from address for this content record (the address of the person created the record). This can be an email address, phone number, social handle or app link (e.g. na16.salesforce.com:006j000000Pkp1d)
    - `style` (string): Style of this content record (This controls both how it will be displayed in Cloze).
      - Allowed values: `event`, `note`, `todo`
    - `update` (boolean): Update the existing event style record if it's already been imported
    - `uniqueid` (string): A unique identifier for this content record. This will often be the unique Id in an external system so that updates can be matched up with the record in Cloze. This is required for `note` and `todo` styles.
    - `source` (string): The source that this content record originally came from (e.g. todoist.com). This is required for `note` and `todo` styles. Must be a valid domain.
    - `threadid` (string): A unique identifier describing the thread this belongs to. All messages with this same threadid will be threaded together in cloze. An example of a good threadid would be a unique support ticket number.
    - `references` (array): Array of people, companies, or projects related to the communication record.
    - `subject` (string): Subject of the communication record
    - `preview` (string): Preview of the body (if not provided will be automatically created from the body). Must be no longer than 1kb.
    - `body` (string): Body text of the communication record
    - `bodytype` (string): Type of the body. If not specified body is treated as plain text.
      - Allowed values: `html`, `text`
    - `due` (['string', 'number']): date stamp for reminder (1 if "someday"). Can be a string or a UTC timestamp in ms since the epoch. If not provided the reminder is treated as "someday".
    - `links` (array): Array of links to include with this communication
    - `campaignId` (string): Trigger the campaign matching this ID on the from person if there is one
    - `dateFormat` (string): For dates of the form 1/2/2021, this determines if they are parsed as US (month/day/year) or International (day/month/year) dates.
      - Allowed values: `us`, `international`
    - `dryrun` (boolean): Run all validation but do not create/update the record
    - `skipImport` (boolean): Entirely ignore the record (do not validate, create, or update the record)

**Request Example:**

```json
{
  "date": "2018-11-20T11:45:13Z",
  "style": "note",
  "from": "dave@incfire.com",
  "uniqueid": "abc123456789",
  "source": "example.org",
  "subject": "Met with dana to discuss the contract",
  "body": "We discussed the pricing terms in detail"
}
```

**Responses:**


- **`200`**: Error Response

---

### POST /v1/timeline/todo/create

**Summary:** Create a to do

**Description:**

Create a new To Do within Cloze


**Authentication:**

- OAuth 2.0 (scopes: change_content)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`todo`** (body, Optional): The To Do to create
  - Body properties:
    - `when` (['string', 'number']): date stamp for reminder (1 if "someday"). Can be a string or a UTC timestamp in ms since the epoch. If not provided the To Do is treated as "someday".
    - `subject` (string): Subject or description for this To Do
    - `preview` (string): Preview of the body (if not provided will be automatically created from the body). Must be no longer than 1kb.
    - `participants` (array): Array of people and companies related to the To Do. Each must be email addresses or other unique identifier (e.g. mobile phone numbers) for people, or domain name for company
    - `assigner` (string): The Cloze user that is assigning the To Do This must be email addresses or other unique identifier of the user. If not provided, the assigner is the user making the request.
    - `assignee` (string): The Cloze user this To Do is being assigned to This must be email addresses or other unique identifier of the user. If not assigned it is for the user making the request. The user must have permission to view team members and import team data to do this.
    - `dateFormat` (string): For dates of the form 1/2/2021, this determines if they are parsed as US (month/day/year) or International (day/month/year) dates.
      - Allowed values: `us`, `international`
    - `dryrun` (boolean): Run all validation but do not create/update the record
    - `skipImport` (boolean): Entirely ignore the record (do not validate, create, or update the record)

**Request Example:**

```json
{
  "when": "2018-11-20T16:00:00Z",
  "subject": "Launch Black Friday marketing campaign",
  "participants": [
    "dave@incfire.com",
    "dana@incfire.com"
  ]
}
```

**Responses:**


- **`200`**: Error Response

---

---

## Webhooks

Endpoints for subscribing to and managing webhook notifications for real-time updates on relation changes.

### GET /v1/webhooks

**Summary:** List subscriptions

**Description:**

This method lets you list your subscriptions


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Responses:**


- **`200`**: Subscription

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "list": [
      {
        "uniqueId": "iwpEBI9YmItIa90NJFsiqKWmPZuQ5r_pJh5wtmr-xyHrOZvKymhvhgkTcVMwfuzxOl9xN3M69Dr9OPhhRYfRQQ",
        "event": "person.audit.change",
        "target_url": "https://mycallback/cloze/hook/person.audit.change",
        "scope": "local",
        "date": 1537284209830,
        "usage": {
          "resumeDate": 1537373306393,
          "lastSendAttempt": 1537375777210,
          "successCount": 7,
          "lastSuccessfulSend": 1537373603674,
          "failCount": 1
        }
      }
    ]
  }
  ```

---

### POST /v1/webhooks/subscribe

**Summary:** Subscribe to change events

**Description:**

This method allows you to subscribe to notifications from Cloze such as when a ***relation(person, project, or company)*** changes.
Notifications are delivered using Web hooks, the callback URL, *target_url* is supplied in the subscription.

### Event Types
For subscriptions that monitor *changes*, there are two event types:


***relation audit changes*** - notifications co-incide with Cloze audit trail entries(that appear in the
Cloze timeline views) and contain the ***audited before and after changes*** in addition to the *person*, *project*, or
*company*.

***relation changes*** - *person*, *project*, or *company* is delivered on *any* change to a relation, *changes* information is empty.

### Subscription Scope
For **team users with export team data rights**, changes may be monitored against the team's relations or against the user's own local
relations. A ***scope*** property, ***team***, ***local***, or prefix, ***hierarchy:***  sets this. By default *team users
with export team data rights* subscribe to *team* relation changes. All other users may subscribe to their own local relations;
they are not authorized to subscribe to team or hierarchy changes. The *hierarchy:* prefixed scope is similar to *team* scope and may be
used where  *hierarchies* are available. The *hierarchy:* scope allows you to see relations *at and below a position* in the hierarchy.
The following example shows all relations at the /USA/West sub-team level: _"hierarchy:/USA/West"_. To show relations at and below
use: _"hierarchy:/USA/West/*"_. To show relations at below the top team-level, and equivalent to _team_ scope,
use: _"hierarchy:/*"_.

### Event Filters
Change notifications may be filtered by Cloze by providing a ***filters*** specification.

### Relation Filters
Relation filters select which relations are examined for changes:  what type of relation (person,
project, or company), and what values certain specified properties must have, to generate a webhook
notification.

Example:  Filter for people in segment "Buyer", stage "Warm" with specific values for custom fields
`lead-origin` and `lead-source`
```
{
    "person":
    {
        "segment": "Buyer",
        "stage": "Warm",
        "customFields":
        [
            { "id": "lead-origin", "value": "team" },
            { "id": "lead-source", "value": "zillow" }
        ]
    }
}
```

### Change Filters
Change filters determine which types of audit changes generate webhook notifications for the subscription.
Audit changes include changes to the relation's `segment`, `stage`,  and changes to any of the relation's
custom fields.

Note:  change filters are only applicable for relation audit change subscriptions - `person.audit.change`,
`project.company.change` or `company.audit.change`.

Example: changes in a person's stage from "lead" to any other stage
```
{
    "changes":
    {
        "stage": { "before": "Lead", "after": "*" }
    }
}
```
Example: only changes where the custom field "is-contacted" has been set to "Yes"
```
{
    "changes":
    {
        "is-contacted": { "after": "Yes" }
    }
}
```
Example: For custom fields you can use the field name instead of the unique id.
```
{
    "changes":
    {
        "Is Contacted": { "after": "Yes" }
    }
}
```

For subscriptions to relation audit changes, you can combine both relation filters and change filters -
for example, this filter limits notifications to people in segment `"Buyer"`, stage `"Warm"`, with specific
`lead-source` and `lead-origin` values, and only when the `is-contacted` custom field is changed to Yes

```
{
    "person":
    {
        "segment": "Buyer",
        "stage": "Warm",
        "customFields":
        [
            { "id": "lead-origin", "value": "team" },
            { "id": "lead-source", "value": "zillow" }
        ]
    },
    "changes":
    {
        "is-contacted": { "after": "Yes" }
    }
}
```

### Notification Format
Change notifications for *relations* are delivered as a array of objects. Each relation is delivered in a format that is
identical(symmetrical) to that used to add(or change) the relation. Please refer to the *Relations* section for
details.

### HTTP Headers
All change notifications will contain an HTTP header, ***X-Cloze-Subscription-ID***, which contains the uniqueid assigned to
the subscription. For subscriptions that are created with a client reference, the client reference is provided in the
HTTP header, ***X-Cloze-Client-Reference***.

### Webhook Response
Change notifications must be responded to with a proper confirmation response. The following forms of confirmation response
are accepted:

  * *text/plain* content-type and body *OK*
  * *application/json* content-type and body *{ "status" : "ok" }*

### Notification Retry and Suspension
Any other form of response(other than legitimate failures) will result in immediate suspension of the subscription.

Subscriptions will also be suspended if notifications are redirected more than 2 times.

The following conditions are considered failures that may be retried:

  * The notification fails to receive a response within *10 seconds*
  * A status code outside the range of 200–4xx is received
  * A network error is encountered

Audit change subscriptions will be retried up to 3 times, using exponential backoff
at 30 seconds, then 90 seconds, then 270 seconds. Subscriptions to basic relation changes are retried
one time after 30 seconds.

The overall rate of notification success is monitored over daily periods: if there are at least 15
notification failures over a day period, and the overall failure rate over the period rises above 10%,
the subscription will be suspended

Excessive or unresponsive notifications during day, hour and minute periods may also lead to the
subscription being suspended by Cloze:

* More than 5 failures per minute
* More than 10 failures per hour
* More than 25 failures per day

Once a subscription is suspended, it can be reactivated in one of two ways:

 * Manually by the target account user, in Settings -> Webhooks
 * By unsubscribing and re-subscribing programmatically

**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`subscription`** (body, Optional): The subscription to create.
  - Body properties:
    - `event` (string): name of the event being subscribed to
      - Allowed values: `person.change`, `project.change`, `company.change`, `person.audit.change`, `project.audit.change`, `company.audit.change`
    - `target_url` (string): callback URL to be called by the Web hook
    - `scope` (string): scope of subscription, changes to the user's local person, project, and company may be monitored, or team relations may be monitored, or team hierarchies can be monitored
      - Allowed values: `local`, `team`, `hierarchy:/X/Y/Z`, `hierarchy:/X/Y/Z/*`
    - `filters` (array): Filters applied by Cloze prior to delivering person, project, and company Web hooks. Filters is an array of one
or more filter objects, only one of which needs to match to allow a notification to be delivered to a subscriber.
Each filter may contain one or two key/value pairs. In the first form of key/value pair, key is "person",
"project" or "company" depending on the subscription; value is a fragment of JSON required for matching the
associated resource. For subscriptions to *audit changes*, the notifications provide change information.
A second key/value pair, where key is "changes", may be provided to filter against the change information.
For a candidate resource to match all names, values and structure of the JSON
fragment must appear in the resource. Presence of the string "*" in the fragment is treated as a
wildcard for matching purposes.
    - `client_type` (string): optional client or implementation information, e.g. "human" format means record fields are returned in the same values you’d normally see displayed in the UI.
    - `client_reference` (string): optional client provided name used to identify and reference subscriptions. To unsubscribe the client may provide
either client_reference and event name, or, the Cloze allocated uniqueid and event name. Multiple subscribes using the same event
name and client reference will replace existing an existing subscription of the same event name and client reference
    - `ttl` (string): optional subscription TTL. Lets you specify time to live for the subscription. TTL is specified in seconds.

**Request Example:**

```json
{
  "event": "person.audit.change",
  "target_url": "https://mycallback/cloze/hook/person.audit.change",
  "scope": "local",
  "filters": [
    {
      "person": {
        "first": "Tom"
      },
      "changes": {
        "stage": {
          "after": "done"
        }
      }
    }
  ]
}
```

**Responses:**


- **`200`**: Subscription

  **Example Response:**

  ```json
  {
    "errorcode": 0,
    "uniqueid": "iwpEBI9YmItIaXXXXXqARvJd8umaeduzRiu7-RD_LrOZvKymhvhgkTcVMwfuzxnrlg9O2dXVk4nWNh08AETg"
  }
  ```

---

### POST /v1/webhooks/unsubscribe

**Summary:** Cancel a subscription

**Description:**

This method lets you unsubscribe from change events


**Authentication:**

- OAuth 2.0 (scopes: read_relation)
- Bearer token (API key)
- API Key (query parameter or header)

**Request Content-Type:** application/json

**Response Content-Type:** application/json

**Parameters:**

- **`subscription`** (body, Optional): The subscription to remove.
  - Body properties:
    - `event` (string): name of the event being subscribed to
    - `uniqueid` (string): unique subscription identifier, this in conjunction with event name may be to unsubscribe.
    - `client_reference` (string): client subscription reference, if provided by subscribe, may be used in conjunction with event name to unsubscribe.

**Request Example:**

```json
{
  "event": "person.audit.change",
  "uniqueid": "iwpEBI9YmItIaXXXXXqARvJd8umaeduzRiu7-RD_LrOZvKymhvhgkTcVMwfuzxnrlg9O2dXVk4nWNh08AETg\\"
}
```

**Responses:**


- **`200`**: Subscription

  **Example Response:**

  ```json
  {
    "errorcode": 0
  }
  ```

---

## Webhook Events

Cloze supports the following webhook event types:

- `person.change` - Notifications when a person relation changes
- `project.change` - Notifications when a project relation changes
- `company.change` - Notifications when a company relation changes
- `person.audit.change` - Notifications with audit trail information when a person relation changes
- `project.audit.change` - Notifications with audit trail information when a project relation changes
- `company.audit.change` - Notifications with audit trail information when a company relation changes

### Webhook Notification Format

Webhook notifications are delivered as HTTP POST requests to your callback URL. The request body contains the changed relation data in the same format used by the API for creating/updating relations.

### Webhook Headers

- `X-Cloze-Subscription-ID`: The unique subscription identifier
- `X-Cloze-Client-Reference`: The client reference (if provided during subscription)

### Webhook Response Requirements

Your webhook endpoint must respond with one of the following:

- `text/plain` content-type with body `OK`
- `application/json` content-type with body `{"status": "ok"}`

Any other response will result in subscription suspension.

---

## Quick Reference

### Endpoint Summary

| Category | Endpoints | Description |
|----------|-----------|-------------|
| **Analytics** | 6 | Activity metrics, team analytics, funnel data, leads |
| **Team** | 4 | Team members, roles, organizational structure |
| **Account** | 7 | User profile, custom fields, stages, segments, steps, views |
| **Projects** | 6 | Create, update, retrieve, find, feed, delete projects |
| **People** | 6 | Create, update, retrieve, find, feed, delete people |
| **Companies** | 6 | Create, update, retrieve, find, feed, delete companies |
| **Timeline** | 4 | Create communications/content/todos, message opens |
| **Webhooks** | 3 | Subscribe, unsubscribe, list webhook subscriptions |

### HTTP Methods

- **GET** - Retrieve data
- **POST** - Create new resources or perform queries
- **PUT** - Update resources (not currently used)
- **DELETE** - Delete resources

### Common Response Format

All endpoints return JSON with the following structure:

```json
{
  "errorcode": 0,
  "message": "Optional error message",
  // ... endpoint-specific data
}
```

- `errorcode: 0` indicates success
- Non-zero error codes indicate various error conditions

### Rate Limiting

Rate limits may apply to API requests. Check response headers for rate limit information.

### Support

For API support, contact: **support@cloze.com**

---

**Documentation Version:** 2025.10  
**Last Updated:** December 2025
