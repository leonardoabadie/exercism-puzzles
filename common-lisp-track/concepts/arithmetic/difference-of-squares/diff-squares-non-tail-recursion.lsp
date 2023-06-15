;;;; Exercism's challenge: difference of squares
;;;; Iteration: 1
;;;; Coder: MGB (Matias GoldenBytes)
;;;; Date: ( 2023/06/15 - 05-42PM ) 
;;;; Using non-tail recursion

(defun rec-sum (n)
  (if (= n 1) 1
    (+ n 
      (rec-sum (- n 1))
    )
  )
)

(defun square-of-sum (n)
  (expt (rec-sum n)
    2
  )  
)      

(defun sum-of-squares (n)
  (if (= n 1) 1
    (+ (expt n 2)
      (sum-of-squares (- n 1))
    )
  )
)

(defun difference (n)
  (abs
    (-
      (square-of-sum n)
      (sum-of-squares n)
    )  
  )
)
