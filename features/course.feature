Feature: Course creation
  In order to craete a course
  As Administrator
  I need to be able to pick a Stage, Level and Subject from a Education System

  Rules:
  - A course is defined by stage, level and subject
  - A course has a Teacher

  Scenario: Creating a course from first time
    Given there is a "Matemáticas" Subject
    And there is a "1º EP" EducationLevel
    And there is a CourseBuilder
    When I create a new Course
    Then I should have a new Course
    And the name of the Course should be "Matemáticas 1º EP"
