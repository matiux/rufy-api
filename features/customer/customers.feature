Feature: Testing Customer API
  In order to handle a restaurant customer
  As a user
  I want to able to handle basic CRUD operation on Customer controller

  Rules:
  - Create
  - Show
  - Update
  - Delete
  - List

  Background: Steps that run before each scenario
    Given that im logged in with credentials "matiux" "281285"

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
    Then the response status code should be 201
    And the response type should be "application/json"
    And the response contains key "data"
    And "data" contains:
      """
      id
      name
      phone
      email
      privacy
      newsletter
      restaurant
      """
    And "data" doesn't contains:
      """
      """

  @updatereservation
  Scenario: Update an existing Customer
    Given that I want update an existing "/v1/customer/1" with values:
      | field      | value      |
      | phone      | 3664589968 |
      | newsletter | 1          |
    When I request a resource
    Then the response status code should be 204

  @singlecustomer
  Scenario: Get a Customer by ID
    Given that I want to find a "/v1/customers/1"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response contains key "data"
    And "data" contains:
      """
      id
      name
      phone
      email
      privacy
      newsletter
      restaurant
      """
    And "data" doesn't contains:
      """
      """

  @singlenotpermittedcustomer
  Scenario: Get an Area of another restaurant by ID
    Given that I want to find a "/v1/customers/2"
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"
