;;;; Exercism's challenge: difference of squares
;;;; Iteration: 2
;;;; Coder: MGB (Matias GoldenBytes)
;;;; Date: ( 2023/06/15 - 06:03PM ) 
;;;; Using tail recursion

(defun rec-sum (number result)
  (if (= number 0) result
    ( 
      rec-sum (- number 1) (+ result number)
    )
  )
)

(defun square-of-sum (number)
  (expt (rec-sum number 0)
    2
  )  
)

(defun sum-of-squares (number &optional (result 0))
  (if (= number 0) result
    (sum-of-squares
      (- number
        1
      ) 
      (+ result
        (expt number 2) 
      )
    )
  )
)

(defun difference (number)
  (abs
    (-
      (square-of-sum number)
      (sum-of-squares number 0)
    )  
  )
)
