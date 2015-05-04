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
      | reservationOptions | 3,2                 |
    When I request a resource
    Then the response status code should be 201
    And the response type should be "application/json"
    And the response contains key "data"
    And "data" contains:
      """
      name
      phone
      area
      areaId
      tableName
      people
      peopleExtra
      date
      note
      time
      status
      drawingWidth
      drawingHeight
      drawingPosX
      drawingPosY
      reservationOptions
      """
    And "data" doesn't contains:
      """
      """
    And "data.reservationOptions" contains:
      """
      data
      """
    And "data.reservationOptions.data.0" contains:
      """
      id
      slug
      """

  @createreservation
  Scenario: Creating a New Reservation
    Given that I want to add a new "/v1/reservations" with values:
      | field             | value               |
      | people            | 6                   |
      | people_extra      | 2                   |
      | time              | 20:30:00            |
      | date              | 2015-04-15          |
      | note              | Hanno un cane       |
      | status            | 2                   |
      | table_name        | 15                  |
      | customer          | 1                   |
      | area              | 1                   |
      |reservationOptions | 4,2                 |
    When I request a resource
    Then the response status code should be 201
    And the response type should be "application/json"
    And the response contains key "data"
    And "data" contains:
      """
      name
      phone
      area
      areaId
      tableName
      people
      peopleExtra
      date
      note
      time
      status
      drawingWidth
      drawingHeight
      drawingPosX
      drawingPosY
      reservationOptions
      """
    And "data" doesn't contains:
      """
      """
    And "data.reservationOptions" contains:
      """
      data
      """
    And "data.reservationOptions.data.0" contains:
      """
      id
      slug
      """

  @singlereservation
  Scenario: Get a Reservation by ID
    Given that I want to find a "/v1/reservations/4"
    When I request a resource
    Then the response status code should be 200
      And the response type should be "application/json"
      And the response contains key "data"
      And "data" contains:
        """
        name
        phone
        area
        areaId
        tableName
        people
        peopleExtra
        date
        note
        time
        status
        drawingWidth
        drawingHeight
        drawingPosX
        drawingPosY
        reservationOptions
        """
      And "data.reservationOptions" contains:
        """
        data
        """
      And "data.reservationOptions.data.0" contains:
        """
        id
        slug
        """

  @notexistssinglereservation
  Scenario: Get a Reservation by ID
    Given that I want to find a "/v1/reservations/1050"
    When I request a resource
    Then the response status code should be 404
    And the response type should be "application/json"

  @notpermittedsinglereservation
  Scenario: Get a Reservation of another restaurant by ID
    Given that I want to find a "/v1/reservations/2"
    When I request a resource
    Then the response status code should be 403
    And the response type should be "application/json"

  @collectionreservation
  Scenario: Get a collection of Reservation by restaurant ID
    Given that I want to find a "/v1/restaurants/1/reservations"
    When I request a resource
    Then the response status code should be 200
      And the response type should be "application/json"
      And the response contains key "data"
      And "data" is a collection
      And each "data" item contains:
        """
        name
        phone
        area
        areaId
        tableName
        people
        peopleExtra
        date
        note
        time
        status
        drawingWidth
        drawingHeight
        drawingPosX
        drawingPosY
        reservationOptions
        """

  @collectionnotpermittedreservation
  Scenario: Get a collection of Reservation by not permitted restaurant ID
    Given that I want to find a "/v1/restaurants/2/reservations"
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
    Then the response status code should be 204

  @softdeletereservation
  Scenario: Delete a Reservation
    Given that I want to delete "/v1/reservations/3":
    When I request a resource
    Then the response status code should be 204

  @softdeletereservationnotexists
  Scenario: Delete a non existent Reservation
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
