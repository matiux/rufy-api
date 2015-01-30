Feature: Testing Reservation model
  In order to handle a user reservation
  As a user
  I want to able to handle basic CRUD operation on Reservation model

  Rules:
  - Create
  - Show
  - Update
  - Delete

  Scenario: Get a Reservation by ID
    Given that I want to find a "/v1/reservations/1"
    When I request a resource
#    Then the response status code should be "200"
#      And response type is "Json"
#      And response contains:
#        """
#        name
#        phone
#        area
#        tableName
#        turn
#        people
#        date
#        time
#        confirmed
#        waiting
#        drawingWidth
#        drawingHeight
#        drawingPosX
#        drawingPosY
#        """


#  Scenario Outline: Create a new Reservation
#    Given that I want to add a new "reservation"
#
#    Examples:
#      | id | people | area_id | date       | time  | confirmed | table_name | customer_id | turn_id | waiting | properties         |
#      | 3  | 1      | 2       | 29/12/2014 | 21:15 | 1         | 12         | 2           | 2       | 0       | created,message    |
#      | 4  | 2      | 2       | 29/12/2014 | 22:30 | 1         | 15         | 1           | 3       | 0       | created,message    |
