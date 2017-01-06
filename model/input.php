<?php

// Zadanie - wyznacz najkrótszą drogę pomiędzy punktem 's' a 'm'.
// Oznacz kolejne pola po jakich się ruszasz, omijaj x.
// Możesz ruszać się tylko w górę, prawą, dół i lewą, nie na skos.
// Wynik zaprezentuj w formie graficznej (style wyżej), użyj OOP.

$input = [
   'Mapa #1 3x3' => [
       ['s',' ',' ',],
       [' ',' ',' ',],
       [' ',' ','m',],
   ],
   'Mapa #2 3x3' => [
       ['s',' ',' ',],
       ['x','x',' ',],
       [' ',' ','m',],
   ],
   'Mapa #3 4x4' => [
       [' ',' ',' ','s',],
       [' ','x','x','x',],
       [' ',' ','x','m',],
       [' ',' ',' ',' ',],
   ],
   'Mapa #3 4x5' => [
       [' ',' ',' ',' ',],
       ['s',' ','x',' ',],
       [' ',' ','x','m',],
       [' ',' ','x',' ',],
       [' ',' ',' ',' ',],
   ],
];

?>

