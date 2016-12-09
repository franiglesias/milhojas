Feature: Provide student info for bounded contexts
    As a Developer
    I want to have a read-only central point to gaher information about students
    In order to provide them with some services

    Scenario: A bounded context ask for data for one student
        Given There is a Student with id 'student-01' and name 'Pedro Pérez' that is in class 'EP 3 C'
        When I ask for student named 'Pedro Pérez'
        Then I should get a StudentDTO object with information
            | studentId | student-01 |
            | name | Pedro |
            | surname | Pérez |
            | class | EP 3 C |
