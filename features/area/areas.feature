Feature: Testing Area API
  In order to handle a restaurant areas
  As a user
  I want to able to handle basic CRUD operation on Area controller

  Rules:
  - Create
  - Show
  - Update
  - Delete
  - List

  Background: Steps that run before each scenario
    Given im logged in with credentials "matiux" "281285"

  @singlearea
  Scenario: Get an Area by ID
    Given that I want to find a "/v1/areas/1"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response contains key "data"
    And "data" contains:
      """
      id
      restaurant_id
      name
      full
      """

  @collectionarea
  Scenario: Get a collection of Area by restaurant ID
    Given that I want to find a "/v1/restaurants/1/areas"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response contains key "data"
    And "data" is a collection
    And each "data" item contains:
        """
        id
        restaurant_id
        name
        full
        """
