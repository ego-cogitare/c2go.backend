<?php

use Illuminate\Database\Seeder;
use App\Models\UserSetting;
use App\Interfaces\IUserSettings;
use App\Models\User;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    const NAMES = [
        'Robert De-Niro',
        'Jack Nicholson',
        'Tom Hanks',
        'Marlon Brando',
        'Leonardo DiCaprio',
        'Humphrey Bogart',
        'Johnny Depp',
        'Al Pacino',
        'Denzel Washington',
        'Laurence Olivier',
        'Brad Pitt',
        'Daniel Day-Lewis',
        'Tom Cruise',
        'Cary Grant',
        'Dustin Hoffman',
        'Clark Gable',
        'Sean Penn',
        'Christian Bale',
        'Gregory Peck',
        'Harrison Ford',
        'Spencer Tracy',
        'George Clooney',
        'Charlton Heston',
        'Anthony Hopkins',
        'Russell Crowe',
        'Katharine Hepburn',
        'Meryl Streep',
        'Ingrid Bergman',
        'Marilyn Monroe',
        'Jennifer Lawrence',
        'Kate Winslet',
        'Elizabeth Taylor',
        'Cate Blanchett',
        'Audrey Hepburn',
        'Helen Mirren',
        'Bette Davis',
        'Nicole Kidman',
        'Sandra Bullock',
        'Natalie Portman',
        'Jodie Foster',
        'Judi Dench',
        'Amy Adams',
        'Julia Roberts',
        'Emma Thompson',
        'Diane Keaton',
        'Grace Kelly',
        'Shirley MacLaine',
        'Reese Witherspoon',
        'Charlize Theron',
        'Judy Garland',
        'John Wayne',
        'Sidney Poitier',
        'Paul Newman',
        'Matt Damon',
        'Robert Duvall',
        'James Dean',
        'Kirk Douglas',
        'Henry Fonda',
        'Robin Williams',
        'Orson Welles',
        'Christoph Waltz',
        'Heath Ledger',
        'Sean Connery',
        'Kevin Spacey',
        'Gene Hackman',
        'Liam Neeson',
        'Edward Norton',
        'Bruce Willis',
        'Gary Cooper',
        'Philip Hoffman',
        'Robert Redford',
        'Ralph Fiennes',
        'Joaquin Phoenix',
        'Will Smith',
        'Steve McQueen',
        'Vivien Leigh',
        'Angelina Jolie',
        'Anne Hathaway',
        'Maggie Smith',
        'Olivia Havilland',
        'Barbara Stanwyck',
        'Joan Fontaine',
        'Greer Garson',
        'Faye Dunaway',
        'Susan Hayward',
        'Ellen Burstyn',
        'Jane Wyman',
        'Sophia Loren',
        'Joan Crawford',
        'Kathy Bates',
        'Julie Andrews',
        'Marion Cotillard',
        'Deborah Kerr',
        'Sissy Spacek',
        'Susan Sarandon',
        'Luise Rainer',
        'Glenn Close',
        'Doris Day',
        'Natalie Wood',
        'Jane Fonda',
    ];

    const PHOTOS = [
        'https://m.media-amazon.com/images/M/MV5BMjAwNDU3MzcyOV5BMl5BanBnXkFtZTcwMjc0MTIxMw@@._V1_UY209_CR9,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQ3OTY0ODk0M15BMl5BanBnXkFtZTYwNzE4Njc4._V1_UY209_CR5,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQ2MjMwNDA3Nl5BMl5BanBnXkFtZTcwMTA2NDY3NQ@@._V1_UY209_CR2,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTg3MDYyMDE5OF5BMl5BanBnXkFtZTcwNjgyNTEzNA@@._V1_UY209_CR65,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjI0MTg3MzI0M15BMl5BanBnXkFtZTcwMzQyODU2Mw@@._V1_UY209_CR7,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTIyOTE3MDM5Ml5BMl5BanBnXkFtZTYwMzA2MTM2._V1_UY209_CR10,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTM0ODU5Nzk2OV5BMl5BanBnXkFtZTcwMzI2ODgyNQ@@._V1_UY209_CR3,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQzMzg1ODAyNl5BMl5BanBnXkFtZTYwMjAxODQ1._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjE5NDU2Mzc3MV5BMl5BanBnXkFtZTcwNjAwNTE5OQ@@._V1_UY209_CR8,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTkwNjYwNDE5M15BMl5BanBnXkFtZTYwNzg0MDQ2._V1_UY209_CR13,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjA1MjE2MTQ2MV5BMl5BanBnXkFtZTcwMjE5MDY0Nw@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjE2NDY2NDc1Ml5BMl5BanBnXkFtZTcwNjAyMjkwOQ@@._V1_UY209_CR9,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTk1MjM3NTU5M15BMl5BanBnXkFtZTcwMTMyMjAyMg@@._V1_UY209_CR9,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BNzYyODM4NDU1MV5BMl5BanBnXkFtZTYwMjI1ODM2._V1_UY209_CR11,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTc3NzU0ODczMF5BMl5BanBnXkFtZTcwODEyMDY5Mg@@._V1_UY209_CR8,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjE1NDY5MjM5Ml5BMl5BanBnXkFtZTYwNTU1OTQ2._V1_UY209_CR10,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTc1NjMzMjY3NF5BMl5BanBnXkFtZTcwMzkxNjQzMg@@._V1_UY209_CR1,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTkxMzk4MjQ4MF5BMl5BanBnXkFtZTcwMzExODQxOA@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjA0ODc0NTE2NF5BMl5BanBnXkFtZTYwNjYyMjQ2._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTY4Mjg0NjIxOV5BMl5BanBnXkFtZTcwMTM2NTI3MQ@@._V1_UY209_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTIwNjE5NTc0OV5BMl5BanBnXkFtZTYwNDU5ODI2._V1_UY209_CR3,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjEyMTEyOTQ0MV5BMl5BanBnXkFtZTcwNzU3NTMzNw@@._V1_UY209_CR7,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTcxMDg1MjYzMV5BMl5BanBnXkFtZTYwMDMxOTE2._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTg5ODk1NTc5Ml5BMl5BanBnXkFtZTYwMjAwOTI4._V1_UY209_CR5,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQyMTExNTMxOF5BMl5BanBnXkFtZTcwNDg1NzkzNw@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTE5NTk4Mjc0OF5BMl5BanBnXkFtZTYwNzI0NDM2._V1_UY209_CR5,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTU4Mjk5MDExOF5BMl5BanBnXkFtZTcwOTU1MTMyMw@@._V1_UY209_CR4,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTYzMTgzMTIwOV5BMl5BanBnXkFtZTYwNzI5MzI2._V1_UY209_CR14,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BNzQzNDMxMjQxNF5BMl5BanBnXkFtZTYwMTc5NTI2._V1_UY209_CR5,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BOTU3NDE5MDQ4MV5BMl5BanBnXkFtZTgwMzE5ODQ3MDI@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BODgzMzM2NTE0Ml5BMl5BanBnXkFtZTcwMTcyMTkyOQ@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQzMTc5MDg0OF5BMl5BanBnXkFtZTgwODE4NjMzNDE@._V1_UY209_CR14,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTc1MDI0MDg1NV5BMl5BanBnXkFtZTgwMDM3OTAzMTE@._V1_UY209_CR2,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTM4MTY3NTQyMF5BMl5BanBnXkFtZTYwMTk2MzQ2._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjA4MzY2ODU2MV5BMl5BanBnXkFtZTcwOTQ3ODY4OQ@@._V1_UY209_CR12,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQ2OTQ4NTU2OF5BMl5BanBnXkFtZTcwMzI3MjY5Ng@@._V1_UY209_CR16,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTk1MjM5NDg4MF5BMl5BanBnXkFtZTcwNDg1OTQ4Nw@@._V1_UY209_CR7,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTI5NDY5NjU3NF5BMl5BanBnXkFtZTcwMzQ0MTMyMw@@._V1_UY209_CR1,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQ3ODE3Mjg1NV5BMl5BanBnXkFtZTcwNzA4ODcxNA@@._V1_UY209_CR8,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTM3MjgyOTQwNF5BMl5BanBnXkFtZTcwMDczMzEwNA@@._V1_UY209_CR1,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BOTI5NjQ4NDc5NF5BMl5BanBnXkFtZTcwMTc5OTczNw@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjE4NjExMjI1OF5BMl5BanBnXkFtZTcwODc0MjY2OQ@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQzNjU3MDczN15BMl5BanBnXkFtZTYwNzY2Njc4._V1_UY209_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTMwNTAyOTg0MF5BMl5BanBnXkFtZTcwNTg0MzY1Mw@@._V1_UY209_CR7,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BNjU5NjMwOTk2NV5BMl5BanBnXkFtZTYwODg1NzY0._V1_UY209_CR3,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTgzNjI4MzY1NF5BMl5BanBnXkFtZTYwMTM4MzQ2._V1_UY209_CR12,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTI0MTE5MjQ1MF5BMl5BanBnXkFtZTYwMzU2MDg1._V1_UY209_CR2,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTc3MDcxMDA5Ml5BMl5BanBnXkFtZTgwNDM1NTU5MDE@._V1_UY209_CR1,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTk5Mzc4ODU0Ml5BMl5BanBnXkFtZTcwNjU1NTI0Mw@@._V1_UY209_CR8,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTYwMTQ0ODMxNF5BMl5BanBnXkFtZTYwNDY2MjU2._V1_UY209_CR13,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTY1NDE0NzgzNl5BMl5BanBnXkFtZTcwNDMwMTUzNw@@._V1_UY209_CR9,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQ0OTE3MzQ2Nl5BMl5BanBnXkFtZTcwMDc2MDc1NA@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BODUwMDYwNDg3N15BMl5BanBnXkFtZTcwODEzNTgxMw@@._V1_UY209_CR15,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTM0NzYzNDgxMl5BMl5BanBnXkFtZTcwMDg2MTMyMw@@._V1_UY209_CR8,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjk1MjA2Mjc2MF5BMl5BanBnXkFtZTcwOTE4MTUwMg@@._V1_UY209_CR4,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTg5NTgzMTkzNl5BMl5BanBnXkFtZTYwMTQwNjI2._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTc1NDc0MjI5NV5BMl5BanBnXkFtZTYwMDE1MjM2._V1_UY209_CR12,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BOTEwNjQ2ODQ4Nl5BMl5BanBnXkFtZTYwMzEwMTM2._V1_UY209_CR13,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BNTYzMjc2Mjg4MF5BMl5BanBnXkFtZTcwODc1OTQwNw@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BOTE1Nzg5NzMwM15BMl5BanBnXkFtZTYwMDQwMTM2._V1_UY209_CR14,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTM4MDk3OTYxOF5BMl5BanBnXkFtZTcwMDk5OTUwOQ@@._V1_UY209_CR6,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTI2NTY0NzA4MF5BMl5BanBnXkFtZTYwMjE1MDE0._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMzcwNTM4MzctYjQzMi00NTA2LTljYWItNTYzNmE1MTYxN2RlXkEyXkFqcGdeQXVyMDI2NDg0NQ@@._V1_UY209_CR11,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTY1NzMyODc3Nl5BMl5BanBnXkFtZTgwNzE2MzA1NDM@._V1_UY209_CR58,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTE5Njk0NDQ4OV5BMl5BanBnXkFtZTYwNjA0Mzc1._V1_UY209_CR1,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjA1MTQ3NzU1MV5BMl5BanBnXkFtZTgwMDE3Mjg0MzE@._V1_UY209_CR35,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTYwNjQ5MTI1NF5BMl5BanBnXkFtZTcwMzU5MTI2Mw@@._V1_UY209_CR11,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjA0MjMzMTE5OF5BMl5BanBnXkFtZTcwMzQ2ODE3Mw@@._V1_UY209_CR19,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTUyMjI1MDEyN15BMl5BanBnXkFtZTYwNzkwNjI2._V1_UY209_CR2,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQ0NTA1NTg3Ml5BMl5BanBnXkFtZTcwNzkxNzgxNw@@._V1_UY209_CR5,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTk1Nzc5MzQyMV5BMl5BanBnXkFtZTcwNjQ5OTA0Mg@@._V1_UY209_CR5,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMzc5MjE1NDgyN15BMl5BanBnXkFtZTcwNzg2ODgwNA@@._V1_UY209_CR10,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BNzAzNjg5MDE3N15BMl5BanBnXkFtZTcwMjIxNzU0OA@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BNTczMzk1MjU1MV5BMl5BanBnXkFtZTcwNDk2MzAyMg@@._V1_UY209_CR2,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQ3Mjk2MTU1MV5BMl5BanBnXkFtZTcwMTA5MTkzNA@@._V1_UY209_CR16,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTI2NTkwMTQ5NF5BMl5BanBnXkFtZTYwNDExNjI2._V1_UY209_CR1,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BODg3MzYwMjE4N15BMl5BanBnXkFtZTcwMjU5NzAzNw@@._V1_UY209_CR15,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BNjQ5MTAxMDc5OF5BMl5BanBnXkFtZTcwOTI0OTE4OA@@._V1_UY209_CR1,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjA4NzYxNjc5Ml5BMl5BanBnXkFtZTYwMTMzOTg1._V1_UY209_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjA0Njc5Mjk5M15BMl5BanBnXkFtZTYwOTk1MjU2._V1_UY209_CR11,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BNjMxODIzODEzNF5BMl5BanBnXkFtZTYwNDgwNjI2._V1_UY209_CR2,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTUwMzk0NjkyMV5BMl5BanBnXkFtZTYwNTUyMjI2._V1_UY209_CR15,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjE4MDg5MjE5NV5BMl5BanBnXkFtZTcwNTcwMDYzOA@@._V1_UY209_CR7,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTk4OTU5MDY0OV5BMl5BanBnXkFtZTYwNTc0MTM1._V1_UY209_CR9,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTI5MDAyODAzOF5BMl5BanBnXkFtZTYwNDUzMzQ2._V1_UY209_CR15,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTU4MjYxMDc3MF5BMl5BanBnXkFtZTYwNzU3MDIz._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjAwNDg3NDI3MV5BMl5BanBnXkFtZTYwNTc0NDU2._V1_UY209_CR12,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BOTczNzg5MzAwMl5BMl5BanBnXkFtZTcwNzE0MjcxNQ@@._V1_UY209_CR6,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjMzNzQ5Mjg5MF5BMl5BanBnXkFtZTYwNTg0NDM2._V1_UY209_CR5,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BNTg1MTM3NjcyMF5BMl5BanBnXkFtZTcwMDI0NTk0Nw@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjExMTYyODA2Ml5BMl5BanBnXkFtZTYwMTgyMDA0._V1_UY209_CR1,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTQxNTEzNTkwNF5BMl5BanBnXkFtZTcwNzQ2NDIwOQ@@._V1_UX140_CR0,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMjEwNTAzNTA2MV5BMl5BanBnXkFtZTYwMjUzMzQ2._V1_UY209_CR12,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BODAwMTU4NTMwMF5BMl5BanBnXkFtZTgwMDMyMTg4MTE@._V1_UY209_CR7,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BM2IyYmE3NjktZTRjYi00YWE3LWIwYjgtOTg1MGZmMmY1ZDA2XkEyXkFqcGdeQXVyODMyNDA5NTQ@._V1_UY209_CR10,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTczMTcxMzIzMl5BMl5BanBnXkFtZTYwNjUyNTM2._V1_UY209_CR5,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTEwNDk5MTU2NTNeQTJeQWpwZ15BbWU3MDczNjEzMTM@._V1_UY209_CR9,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTI4NTQ1MTQwMF5BMl5BanBnXkFtZTYwMzc3ODM2._V1_UY209_CR11,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMTI3NjM5OTgxNF5BMl5BanBnXkFtZTYwOTg4NTM2._V1_UY209_CR2,0,140,209_AL_.jpg',
        'https://m.media-amazon.com/images/M/MV5BMzQ5NTE2MDAzOV5BMl5BanBnXkFtZTgwOTQ3MTQ3MjE@._V1_UY209_CR19,0,140,209_AL_.jpg',
    ];

    /**
     * Run the database seeds.
     * @return void
     * @throws \App\Exceptions\WrongSettingsException
     */
    public function run()
    {
        // Loop through each user above and create the record for them in the database
        foreach (self::NAMES as $i => $name) {
            $user = User::create([
                'first_name' => explode(' ', $name)[0],
                'last_name' => explode(' ', $name)[1],
                'email' => strtolower(str_replace(' ', '', $name)) . '@gmail.com',
                'home_address' => EventsSeeder::CITIES[array_rand(EventsSeeder::CITIES)],
                'verified' => 0,
                'password' => '123456',
                'birth_date' => rand(1, 30) . '.' . rand(1, 12) . '.' . rand(1950, 2000),
                'is_subscribed' => rand(0, 1),
                'progress' => 6,
            ]);

            UserSetting::apply(IUserSettings::PROFILE_PHOTO, self::PHOTOS[$i], $user->id);
            UserSetting::apply(IUserSettings::PROFILE_TYPE, rand(1, 2), $user->id);
        }
    }
}
