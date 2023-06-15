;; Evaluates to some symbol (not a keyword)
(defun lennys-favorite-food()
  'lasagna
)

;; Evaluates to some keyword
(defun lennys-secret-keyword ()
  :aliens-are-real
)

;; Evaluates to T if THING is an atom, NIL otherwise
(defun is-an-atom-p (thing)
  atom thing
)
 
;; Evaluates to T if THING is a cons, NIL otherwise
(defun is-a-cons-p (thing)
  consp thing
)

;; Evaluates to the first part of CONS

(defun fist-thing (cons)
  (car cons)
)

;; Evaluates to the 'rest' of the CONS
(defun rest-of-it (cons)
  (cdr cons)
)
