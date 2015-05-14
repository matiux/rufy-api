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
    Given that im logged in with credentials "mat" "mat"

  @createarea
  Scenario: Creating a New Area
    Given that I want to add a new "/v1/areas" with values:
      | field      | value       |
      | name       | Sala grande |
      | restaurant | 1           |
      | maxPeople  | 55          |
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"
