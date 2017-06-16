#lang racket
(require "soxanwords-final.rkt")

(define dict (append
              x@ xa xb xp
              xte xse xj xc
              xhotti xx xd xzal
              xr xze
              x% xsin x$ xsad
              xzad xta xza xeyn
              xqeyn xf xqaf xk
              xg xl xm xn
              xv xhavvaz xy))

(define new-dict (cart dict '()))
;; Takes a list and makes it into csv format.
;; Required format '((string) (string))
(define (lst->csv lsta filename)
  (let ([file (open-output-file (string-append filename ".csv") #:exists 'replace)])
    (define (helper lst)
      (if (null? lst)
          (void)
          (begin
            (fprintf file "~a, ~a ~n"
                     (caaar lst)
                     (string-join (map ~a (cadar lst)) "\u200A"))  ; Hair space
            (helper (cdr lst)))))
    (begin
      (helper lsta)
      (close-output-port file))))

;;--- Helper functions for cleaning up the list ---

; Prints the list in correct format, for error checking purposes
(define (writer lst)
  (let ([out2 (open-output-file "db5000check.csv" #:exists 'replace)])
    (define (helper lsta)
      (if (null? lsta)
          (void)
          (begin
            (fprintf out2 "~a ~n" (car lsta))
            (writer (cdr lsta)))))
    (begin
      (helper lst)
      (close-output-port out2))))

(define (clean-lst lst)
  (if (null? lst)
      (void)
      (append (clean-helper (caar lst) (cdar lst)) (clean-lst (cdr lst)))))

(define (clean-helper word lst)
  (if (null? lst)
      '()
      (cons (cons word (car lst))
            (clean-helper word (cdr lst)))))

; Writers
(lst->csv new-dict "db5000")

; Error checkers
;(writer new-dict)
;(writer dict)

