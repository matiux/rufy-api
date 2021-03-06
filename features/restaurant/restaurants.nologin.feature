Feature: Testing Restaurant API - No login
  In order to handle a user restaurant
  As a user
  I want to able to handle basic CRUD operation on Restaurant controller

  Rules:
  - Create
  - Show
  - Update
  - Delete
  - List

  @createrestaurant
  Scenario: Creating a New Restaurant
    Given that I want to add a new "/v1/restaurants" with values:
      | field     | value     |
      | name      | La stalla |
      | rest_date | 1         |
    When I request a resource
    Then the response status code should be 401
    And the response type should be "application/json"

  @singlerestaurant
  Scenario: Get a Restaurant by ID
    Given that I want to find a "/v1/restaurants/1"
    When I request a resource
    Then the response status code should be 401
    And the response type should be "application/json"

  @collectionrestaurant
  Scenario: Get all user's restaurants
    Given that I want to find a "/v1/restaurants"
    When I request a resource
    Then the response status code should be 401
    And the response type should be "application/json"

  @softdeleterestaurant
  Scenario: Delete a Restaurant
    Given that I want to delete "/v1/restaurants/2":
    When I request a resource
    Then the response status code should be 401

  @endtest
  Scenario: Terminate test
    Given that I want complete the test
