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
    Given that I prepare database
    And that im logged in with credentials "matiux" "281285"
#    Given that im logged in with credentials "matiux" "281285"

  @createreservation
  Scenario: Creating a New Reservation
    Given that I want to add a new "/v1/reservations" with values:
      | field              | value               |
      | people             | 4                   |
      | time               | 21:15:00            |
      | date               | 2015-05-26          |
      | note               | Hanno un passeggino |
      | confirmed          | 1                   |
      | waiting            | 0                   |
      | table_name         | 12                  |
      | customer           | 2                   |
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
          date
          note
          time
          confirmed
          waiting
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

  @createreservation
  Scenario: Creating a New Reservation
    Given that I want to add a new "/v1/reservations" with values:
      | field             | value               |
      | people            | 6                   |
      | time              | 20:30:00            |
      | date              | 2015-04-15          |
      | note              | Hanno un cane       |
      | confirmed         | 1                   |
      | waiting           | 0                   |
      | table_name        | 15                  |
      | customer          | 1                   |
      | area              | 2                   |
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
          date
          note
          time
          confirmed
          waiting
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
        date
        note
        time
        confirmed
        waiting
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
        date
        note
        time
        confirmed
        waiting
        drawingWidth
        drawingHeight
        drawingPosX
        drawingPosY
        reservationOptions
        """

  @updatereservation
  Scenario: Update an existing Reservation
    Given that I want update an existing "/v1/reservations/5" with values:
      | field             | value               |
      | people            | 5                   |
      | time              | 21:30:00            |
      | table_name        | 15                  |
      | area              | 2                   |
      |reservationOptions | 1,2                 |
    When I request a resource
    Then the response status code should be 204

#  @softdeletereservation
#  Scenario: Delete a Reservation
#    Given that I want delete a reservation "/v1/reservations/4":
#    When I request a resource
#    Then the response status code should be 204
#
#  @softdeletereservation
#  Scenario: Delete a Reservation
#    Given that I want delete a reservation "/v1/reservations/5":
#    When I request a resource
#    Then the response status code should be 204
