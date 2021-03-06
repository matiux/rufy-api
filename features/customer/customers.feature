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
    And the response contains:
      """
      id
      name
      phone
      email
      privacy
      newsletter
      restaurant
      """

  @singlecustomer
  Scenario: Get a Customer by ID
    Given that I want to find a "/v1/customers/1"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response contains:
      """
      id
      name
      phone
      email
      privacy
      newsletter
      restaurant
      """

  @singlenotpermittedcustomer
  Scenario: Get a Customer of another restaurant by ID
    Given that I want to find a "/v1/customers/2"
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @singlenotexistingscustomer
  Scenario: Get a Customer from not existing restaurant
    Given that I want to find a "/v1/customers/1050"
    When I request a resource
    Then the response status code should be 404
    And the response type should be "application/json"

  @updatereservation
  Scenario: Update an existing Customer
    Given that I want update an existing "/v1/customers/1" with values:
      | field      | value      |
      | phone      | 3664589968 |
      | newsletter | 1          |
    When I request a resource
    Then the response status code should be 204

  @updatenotpermittedreservation
  Scenario: Update an existing Customer of another restaurant
    Given that I want update an existing "/v1/customers/2" with values:
      | field      | value      |
      | phone      | 3664589968 |
    When I request a resource
    Then the response status code should be 403

  @updatereservation
  Scenario: Update a non existing Customer
    Given that I want update an existing "/v1/customers/1050" with values:
      | field      | value      |
      | phone      | 3664589968 |
    When I request a resource
    Then the response status code should be 404

  @softdeletecustomer
  Scenario: Delete a Customer
    Given that I want to delete "/v1/customers/1":
    When I request a resource
    Then the response status code should be 204

  @softdeletecustomernotexists
  Scenario: Delete a non existent Customer
    Given that I want to delete "/v1/customers/1050":
    When I request a resource
    Then the response status code should be 404

  @softdeletecustomeranother
  Scenario: Delete a Customer of another Restaurant
    Given that I want to delete "/v1/customers/2":
    When I request a resource
    Then the response status code should be 403


  @collectioncustomer
  Scenario: Get a collection of Customer by restaurant ID
    Given that I want to find a "/v1/restaurants/1/customers"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response is a collection
    And each response item contains:
      """
      id
      name
      phone
      email
      privacy
      newsletter
      restaurant
      """

  @collectionnotpermittedcustomer
  Scenario: Get a collection of Customer by not permitted restaurant ID
    Given that I want to find a "/v1/restaurants/3/customers"
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @collectionfromnotexistingrestaurant
  Scenario: Get a collection of Customer from not existing restaurant
    Given that I want to find a "/v1/restaurants/281285/customers"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And response is void

  @endtest
  Scenario: Terminate test
    Given that I want complete the test
