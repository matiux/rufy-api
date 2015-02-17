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
    Given im logged in with credentials "matiux" "281285"

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

  @collectionrestaurant
  Scenario: Get a Restaurant by ID
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