Feature: Testing Restaurant API
  In order to handle a user restaurant
  As a user
  I want to able to handle basic CRUD operation on Restaurant controller

  Rules:
  - Create
  - Show
  - Update
  - Delete
  - List

  Background: Steps that run before each scenario
    Given that im logged in with credentials "matiux" "281285"

  @createrestaurant
  Scenario: Creating a New Restaurant
    Given that I want to add a new "/v1/restaurants" with values:
      | field     | value     |
      | name      | La stalla |
      | rest_date | 1         |
    When I request a resource
    Then the response status code should be 201
    And the response type should be "application/json"
    And the response contains key "data"
    And "data" contains:
      """
      id
      name
      restDate
      """
    And "data" doesn't contains:
      """
      """

  @updaterestaurant
  Scenario: Update an existing Reservation
    Given that I want update an existing "/v1/restaurants/1" with values:
      | field     | value           |
      | name      | La nuova stalla |
      | rest_date | 3               |
    When I request a resource
    Then the response status code should be 204

  @updatenotpermittedrestaurant
  Scenario: Update an existing Reservation of another restaurant
    Given that I want update an existing "/v1/restaurants/2" with values:
      | field     | value           |
      | name      | La nuova stalla |
      | rest_date | 3               |
    When I request a resource
    Then the response status code should be 403

  @singlerestaurant
  Scenario: Get a Restaurant by ID
    Given that I want to find a "/v1/restaurants/1"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response contains key "data"
    And "data" contains:
      """
      id
      name
      restDate
      """

  @notpermittedsinglerestaurant
  Scenario: Get a Restaurant by ID
    Given that I want to find a "/v1/restaurants/2"
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @nonexistssinglerestaurant
  Scenario: Get a Restaurant by ID
    Given that I want to find a "/v1/restaurants/150"
    When I request a resource
    Then the response status code should be 404
    And the response type should be "application/json"

  @collectionrestaurant
  Scenario: Get all user's restaurants
    Given that I want to find a "/v1/restaurants"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response contains key "data"
    And "data" is a collection
    And each "data" item contains:
      """
      id
      name
      restDate
      """

  @endtest
  Scenario: Terminate test
    Given that I want complete the test
