Feature: Testing Customer API - No login
  In order to handle a restaurant customer
  As a user
  I want to able to handle basic CRUD operation on Customer controller

  Rules:
  - Create
  - Show
  - Update
  - Delete
  - List

  @createcustomer
  Scenario: Creating a New Customer
    Given that I want to add a new "/v1/customers" with values:
      | field      | value           |
      | name       | Pinco Pallo     |
      | phone      | 339 1245987     |
      | email      | pinco@libero.it |
      | privacy    | 1               |
      | newsletter | 0               |
      | restaurant | 1               |
    When I request a resource
    Then the response status code should be 401
    And the response type should be "application/json"

  @singlecustomer
  Scenario: Get a Customer by ID
    Given that I want to find a "/v1/customers/1"
    When I request a resource
    Then the response status code should be 401
    And the response type should be "application/json"

  @collectioncustomer
  Scenario: Get a collection of Customer by restaurant ID
    Given that I want to find a "/v1/restaurants/1/customers"
    When I request a resource
    Then the response status code should be 401
    And the response type should be "application/json"

  @endtest
  Scenario: Terminate test
    Given that I want complete the test
