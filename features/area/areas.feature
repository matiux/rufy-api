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
    Given that im logged in with credentials "matiux" "281285"

  @createarea
  Scenario: Creating a New Area
    Given that I want to add a new "/v1/areas" with values:
      | field      | value       |
      | name       | Sala grande |
      | restaurant | 1           |
      | maxPeople  | 30          |
      | maxPeopleTable  | 12          |
      | minPeopleTable  | 2          |
    When I request a resource
    Then the response status code should be 201
    And the response type should be "application/json"
    And the response contains:
      """
      id
      restaurantId
      name
      max_people
      """

  @singlearea
  Scenario: Get an Area by ID
    Given that I want to find a "/v1/areas/1"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response contains:
      """
      id
      restaurantId
      name
      max_people
      """

  @singlenotpermittedarea
  Scenario: Get an Area of another restaurant by ID
    Given that I want to find a "/v1/areas/2"
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @singlenotexistsarea
  Scenario: Get an Area of another restaurant by ID
    Given that I want to find a "/v1/areas/1050"
    When I request a resource
    Then the response status code should be 404
    And the response type should be "application/json"

  @collectionarea
  Scenario: Get a collection of Area by restaurant ID
    Given that I want to find a "/v1/restaurants/1/areas"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response is a collection
    And each "response" item contains:
      """
      id
      restaurantId
      name
      max_people
      """

  @collectionnotpermittedarea
  Scenario: Get a collection of Area by not permitted restaurant ID
    Given that I want to find a "/v1/restaurants/3/areas"
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @endtest
  Scenario: Terminate test
    Given that I want complete the test
