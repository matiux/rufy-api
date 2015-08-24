Feature: Testing Reservation API
  In order to handle a user reservation
  As a user
  I want to able to handle basic CRUD operation on Reservation controller

  Rules:
  - Create
  - Show
  - Update
  - Delete
  - List

  Background: Steps that run before each scenario
    Given that im logged in with credentials "matiux" "281285"

#  @create
#  Scenario: Creating a New Reservation
#    Given that I want to add a new "/v1/reservations" with values:
#      | field              | value               |
#      | people             | 4                   |
#      | people_extra       | 0                   |
#      | time               | 21:30               |
#      | date               | 2015-05-26          |
#      | note               | Hanno un passeggino |
#      | status             | 1                   |
#      | table_name         | 12                  |
#      | customer           | 1                   |
#      | area               | 1                   |
#    When I request a resource
#    Then the response status code should be 201
#    And the response type should be "application/json"
#    And the response contains:
#      """
#      people
#      time
#      date
#      note
#      people_extra
#      status
#      table_name
#      customer
#      area
#      """
#    And "customer" is a collection
#    And "customer" contains:
#      """
#      name
#      phone
#      email
#      privacy
#      newsletter
#      restaurant
#      id
#      """
#
#  @create
#  Scenario: Creating a New Reservation
#    Given that I want to add a new "/v1/reservations" with values:
#      | field              | value         |
#      | people             | 6             |
#      | people_extra       | 2             |
#      | time               | 20:30         |
#      | date               | 2015-04-15    |
#      | note               | Hanno un cane |
#      | status             | 2             |
#      | table_name         | 15            |
#      | customer           | 1             |
#      | area               | 1             |
#    When I request a resource
#    Then the response status code should be 201
#    And the response type should be "application/json"
#    And the response contains:
#      """
#      people
#      time
#      date
#      note
#      people_extra
#      status
#      table_name
#      customer
#      area
#      """
#    And "customer" is a collection
#    And "customer" contains:
#      """
#      name
#      phone
#      email
#      privacy
#      newsletter
#      restaurant
#      id
#      """

  @createwithnewcustomer
  Scenario: Creating a New Reservation with a new Customer
    Given that I want to add a new "/v1/reservations" with values:
      | field        | value                                                                                          |
      | people       | 6                                                                                              |
      | people_extra | 2                                                                                              |
      | time         | 20:30                                                                                          |
      | date         | 2015-04-15                                                                                     |
      | note         | Hanno un cane                                                                                  |
      | status       | 2                                                                                              |
      | table_name   | 15                                                                                             |
      | customer     | array,name=Pinco Pallo,phone=456987258,email=info@pallo.it,privacy=1,newsletter=0,restaurant=1 |
      | area         | 1                                                                                              |
    When I request a resource
    Then the response status code should be 201
    And the response type should be "application/json"
    And the response contains:
      """
      people
      time
      date
      note
      people_extra
      status
      table_name
      customer
      area
      """
    And "customer" is a collection
    And "customer" contains:
      """
      name
      phone
      email
      privacy
      newsletter
      restaurant
      id
      """

  @single
  Scenario: Get a Reservation by ID
    Given that I want to find a "/v1/reservations/1"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response contains:
      """
      people
      time
      date
      note
      people_extra
      status
      table_name
      customer
      area
      """
    And "customer" is a collection
    And "customer" contains:
      """
      name
      phone
      email
      privacy
      newsletter
      restaurant
      id
      """

  @notexistssingle
  Scenario: Get a not existing Reservation by ID
    Given that I want to find a "/v1/reservations/1050"
    When I request a resource
    Then the response status code should be 404
    And the response type should be "application/json"

  @notpermittedsingle
  Scenario: Get a Reservation of another restaurant by ID
    Given that I want to find a "/v1/reservations/2"
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @collection
  Scenario: Get a collection of Reservation by restaurant ID
    Given that I want to find a "/v1/restaurants/1/reservations"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response is a collection
    And each "response" item contains:
      """
      people
      time
      date
      note
      people_extra
      status
      table_name
      customer
      area
      """

  @voidcollection
  Scenario: Get a voiud collection of Reservation by restaurant ID
    Given that I want to find a "/v1/restaurants/1/reservations?date=2015-06-24"
    When I request a resource
    Then the response status code should be 200
    And the response type should be "application/json"
    And the response is a collection
    And "response" is void

  @collectionnotpermitted
  Scenario: Get a collection of Reservation by not permitted restaurant ID
    Given that I want to find a "/v1/restaurants/3/reservations"
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @update
  Scenario: Update an existing Reservation
    Given that I want update an existing "/v1/reservations/1" with values:
      | field      | value  |
      | people     | 5      |
      | time       | 21:30  |
      | table_name | Angolo |
    When I request a resource
    Then the response status code should be 204

  @updatewithcustomer
  Scenario: Update an existing Reservation
    Given that I want update an existing "/v1/reservations/1" with values:
      | field      | value           |
      | people     | 5               |
      | time       | 21:30           |
      | table_name | Angolo          |
      | customer   | array,name=Gigi |
    When I request a resource
    Then the response status code should be 204

  @softdelete
  Scenario: Delete a Reservation
    Given that I want to delete "/v1/reservations/3":
    When I request a resource
    Then the response status code should be 204

  @softdeletereservationnotexisting
  Scenario: Delete a not existing Reservation
    Given that I want to delete "/v1/reservations/50":
    When I request a resource
    Then the response status code should be 404

  @softdeletereservationanother
  Scenario: Delete a Reservation of another Restaurant
    Given that I want to delete "/v1/reservations/2":
    When I request a resource
    Then the response status code should be 403

  @updatenotpermittedreservation
  Scenario: Update an existing Reservation of another restaurant
    Given that I want update an existing "/v1/reservations/2" with values:
      | field  | value |
      | people | 5     |
    When I request a resource
    Then the response status code should be 403

  @endtest
  Scenario: Terminate test
    Given that I want complete the test
