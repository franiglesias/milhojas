Feature: CantineRule assign CantineUsers to Turns
  In order to assign Turn to Cantine User
  As CantineAdministrator
  I Ask CantineRule to which Turn a CantineUser belongs

  Rules:
  - Rule applies on specifc week days
  - Rule applies on cantine group
  - Rule applies or not given extra information

  Scenario: Assign Turn using a CantineRule for a RegularCantineUser on a date
    Given there is a CantineRule that applies on weekday 'Monday' to CantineGroup 'Group1'
    And there is a RegularCantineUser that has StudentId 'student' that eats on 'Monday' and belongs to CantineGroup 'Group1'
    When I ask for Turn on 'Monday, 2016 14th November'
    Then I should Get '1' as the Turn
