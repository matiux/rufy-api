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

  @endtest
  Scenario: Terminate test
    Given that I want complete the test
