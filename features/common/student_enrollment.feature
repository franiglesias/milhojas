Feature: Manage the enrollment of students
    As User
    I want to be able to enroll students
    In order to manage their data

    Scenario: Enrolling a new Student
        Dados Estoy en '/shared/student/enroll'
        When I fill in 'student[person][name]' with 'Fernando'
        And I fill in 'student_person_surname' with 'López Pérez'
        And I press 'enrollButton'
        Then I should see 'Fernando López Pérez'
