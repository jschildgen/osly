# osly
A script written in PHP to add lilypond music snipples into OpenSong chord sheets.

1. Add lilypond code into your OpenSong files ;<< ... ;>>
2. Export OpenSong sheet to HTML
3. run the following command: php osly.php song.html

Requirements: php, lilypond, opensong

Lilypond compiles the embedded lilypond code snippets into PNG files. 

Example snippet:

```
[V2]
.   F           C7       A7    Dm    Gm C7 F
 La la la la la la la la la la la la la la la.

;<<
; \transpose c f { \chords { \set noChordSymbol = ##f r4 a2:m d4:m g:7 c1 } }
; \transpose c f { \relative c' {
; \key c \major
; \partial 4 e8^"rit."( d)
; c4. a8 a4( g)
; c1 \bar "|."
; } }
;>>
```

The result will look like this:

![Result HTML](https://raw.github.com/jschildgen/osly/master/osly_preview.png)

