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
    Given im logged in with credentials "matiux" "281285"

  @singlereservation
  Scenario: Get a Reservation by ID
    Given that I want to find a "/v1/reservations/1"
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
