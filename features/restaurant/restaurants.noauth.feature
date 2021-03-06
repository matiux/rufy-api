Feature: Testing Restaurant API - No Auth
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
    Given that im logged in with credentials "mat" "mat"

  @createrestaurant
  Scenario: Creating a New Restaurant
    Given that I want to add a new "/v1/restaurants" with values:
      | field     | value     |
      | name      | La stalla |
      | rest_date | 1         |
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @updaterestaurant
  Scenario: Update an existing Reservation
    Given that I want update an existing "/v1/restaurants/3" with values:
      | field     | value           |
      | name      | La nuova stalla |
      | rest_date | 3               |
    When I request a resource
    Then the response status code should be 403


  @softdeleterestaurant
  Scenario: Delete a Restaurant
    Given that I want to delete "/v1/restaurants/2":
    When I request a resource
    Then the response status code should be 403

  @endtest
  Scenario: Terminate test
    Given that I want complete the test
