;;;; Exercism's challenge: difference of squares
;;;; Iteration: 1
;;;; Coder: MGB (Matias GoldenBytes)
;;;; Date: ( 2023/06/15 - 05-42PM ) 
;;;; Using non-tail recursion

(defun rec-sum (number)
  (if (= number 1) 1
    (+ number 
      (rec-sum (- number 1))
    )
  )
)

(defun square-of-sum (number)
  (expt (rec-sum number)
    2
  )  
)      

(defun sum-of-squares (number)
  (if (= number 1) 1
    (+ (expt number 2)
      (sum-of-squares (- number 1))
    )
  )
)

(defun difference (number)
  (abs
    (-
      (square-of-sum number)
      (sum-of-squares number)
    )  
  )
)
