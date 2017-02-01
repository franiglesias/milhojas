Feature: Provide student info for bounded contexts
    As a Developer
    I want to have a read-only central point to gaher information about students
    In order to provide them with some services

    Scenario: A bounded context asks for data for one student
        Given There is a Student with id 'student-01' and name 'Pedro Pérez' and gender 'male' that is in class 'EP 3 C'
        When I ask for student named 'Pedro Pérez'
        Then I should get a StudentDTO object with information
            | studentId | student-01 |
            | name | Pedro |
            | surname | Pérez |
            | class | EP 3 C |
            | gender | m |

    Scenario: Input asks for autocomplete data
        Given There are several Students in the repository
            | studentId | name | surname | gender | class |
            | 01 | Laura | Álvarez | f | EP 1 C |
            | 02 | Pedro | Fernández | m | EP 5 A |
            | 03 | Álvaro | Martínez | m | ESO 4 A |
            | 04 | María | Pérez | f | EP 2 A |
            | 05 | Luis | Sánchez | m | ESO 3 B |
            | 06 | Nerea | Gómez | f | EP 4 B |
        When I ask for a student whose name contains 'Álv'
        Then I should get a list of users that match
            | studentId | student_label |
            | 01 | Laura Álvarez (EP 1 C) |
            | 03 | Álvaro Martínez (ESO 4 A) |

    Scenario: I want to enroll a student
        Given There is a 'male' Student called 'Fernando González' that wants to be enrolled in class 'EP 4 A'
        When I enroll this student
        Then I should have a student named 'Fernando González' in the repository
