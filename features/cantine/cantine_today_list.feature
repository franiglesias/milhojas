Feature: Get the list of today's cantine users
    As a Admin
    I want to get the list of users that will be eating today
    In order to prepare the meals

    Background:
        Given Cantine Configuration is
            """
            turns: ['Turno 1', 'Turno 2', 'Turno 3']
            groups: ['Grupo 1', 'Grupo 2', 'Grupo 3', 'Grupo 4']
            rules: { 'Grupo 1 eats on turn 1 all days': { schedule: [monday, tuesday, wednesday, thursday, friday], group: 'Grupo 1', turn: 'Turno 1' }, 'Grupo 2 eats on turn 2 Mon and Wed': { schedule: [monday, wednesday], group: 'Grupo 2', turn: 'Turno 2' }, 'Grupo 2 eats on turn 3 Tue, Thu, Fri': { schedule: [tuesday, thursday, friday], group: 'Grupo 2', turn: 'Turno 3' } }
            allergens: ['gluten', 'almonds', 'fish', 'eggs']
            """
        And There are some Cantine Users registered
            | name | surname | gender | class | student_id | group | type | schedule | allergies | remarks |
            | Pedro | Pérez | m | EP 3 C | student-01 | Grupo 1 | regular | november: monday, wednesday | gluten |  |
            | Eva | Fernández | f | EP 5 A | student-02 | Grupo 2 | ticket | 11/14/2016 |  | dieta blanda |
            | Luis | Rodríguez | m | ESO 1 A | student-03 | Grupo 3 | regular | november: tuesday, friday |  |  |
            | Isabel | López | f | ESO 4 B | student-04 | Grupo 4 | ticket | 11/25/2016 |  |  |
            | Enrique | Sánchez | m | EP 4 A | student-05 | Grupo 1 | regular | november: monday, friday |  |  |
            | Gabriela | Martínez | f | EP 4 B | student-06 | Grupo 1 | ticket | 11/14/2016 | fish |  |

    @cantine_ui @cantine_app
    Scenario: Admin wants to get the list of taday's users
        Given Today is '11/14/2016'
        When Admin asks for the list
        Then the turns should be assigned as
            | date | turn | student | class | remarks |
            | 11/14/2016 | Turno 1 | Martínez, Gabriela | EP 4 B |  |
            | 11/14/2016 | Turno 1 | Pérez, Pedro | EP 3 C |  |
            | 11/14/2016 | Turno 1 | Sánchez, Enrique | EP 4 A |  |
            | 11/14/2016 | Turno 2 | Fernández, Eva | EP 5 A |  |

    Scenario: Admin wants basic statistics about
        Given Today is '11/14/2016'
        When Admin asks for the list
        Then statistics should look like this
            | turn | total | ei | ep | eso | bach |
            | Turno 1 | 3 | 0 | 3 | 0 | 0 |
            | Turno 2 | 1 | 0 | 1 | 0 | 0 |

    Scenario: Admin wants to know how many students need special meals
        Given Today is '11/14/2016'
        When Admin asks for the list
        Then a list for special meals should look like this
            | turn | student | special |
            | Turno 1 | Martínez, Gabriela | fish |
            | Turno 1 | Pérez, Pedro | gluten |
            | Turno 2 | Fernández, Eva | dieta blanda |
