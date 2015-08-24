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
    Given that im logged in with credentials "mat" "mat"

  @createreservation
  Scenario: Creating a New Reservation
    Given that I want to add a new "/v1/reservations" with values:
      | field              | value               |
      | people             | 4                   |
      | people_extra       | 0                   |
      | time               | 21:15:00            |
      | date               | 2015-05-26          |
      | note               | Hanno un passeggino |
      | status             | 1                   |
      | table_name         | 12                  |
      | customer           | 1                   |
      | area               | 1                   |
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @createreservationwithnewcustomer
  Scenario: Creating a New Reservation with a new Customer
    Given that I want to add a new "/v1/reservations" with values:
      | field              | value         |
      | people             | 6             |
      | people_extra       | 2             |
      | time               | 20:30:00      |
      | date               | 2015-04-15    |
      | note               | Hanno un cane |
      | status             | 2             |
      | table_name         | 15            |
      | customer           | array,name=Pinco Pallo,phone=456987,email=info@pallo.it,privacy=1,newsletter=0,restaurant=1 |
      | area               | 1             |
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @updatereservation
  Scenario: Update an existing Reservation
    Given that I want update an existing "/v1/reservations/1" with values:
      | field             | value               |
      | people            | 5                   |
      | time              | 21:30:00            |
      | table_name        | 15                  |
    When I request a resource
    Then the response status code should be 403

  @softdeletereservation
  Scenario: Delete a Reservation
    Given that I want to delete "/v1/reservations/3":
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
