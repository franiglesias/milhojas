Feature: Extracurricular management
    As an admin
    I need to manage extracurricular activities catalogue
    In order to enroll students and control interaction with other services

    Scenario: New activity is added to empty catalogue
        Given There is a new extracurricular activity 'Robotics' that will run on 'morning' of 'monday, wednesday'
        When It is added to the catalogue
        Then Catalogue should have '1' activity

    Scenario: New activity has several groups
        Given There is a new extracurricular activity 'Arts' that have groups
            | group | time | schedule |
            | EP | morning | monday, friday |
            | ESO | afternoon | monday, friday |
        When It is added to the catalogue
        Then Catalogue should have '2' activities

    Scenario: Student enrolls to one activity
        Given There is a Student Called 'Pedro Díaz'
        And There is an activity in the catalogue called 'Robotics'
        When Student enrolls to activity 'Robotics'
        Then Activity 'Robotics' should be appended to Student's list of activities
