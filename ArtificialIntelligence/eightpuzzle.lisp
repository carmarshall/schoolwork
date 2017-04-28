;Carlyn Marshall
;solution to the AI search problem, the eight puzzle


(defun goal-state (state)
  (if (equal state '(1 2 3 8 e 4 7 6 5)) t nil))

(defun get-direction (move)
  (car move)) ;cond for null lst?

(defun get-state (move)
  (cadr move))

(defun same-state (move1 move2)
  (if (equal (cadr move1)(cadr move2)) t nil))

(defun path (moves)
  (rest(reverse(mapcar #'car moves))))

(defun list-only-states (moves)
  (mapcar #'get-state moves))

(defun is-redundant (state moves2)
  (cond
    ((equal state (car moves2)) t)
    ((null moves2) NIL)
    (t (is-redundant state (cdr moves2)))
  )
)

(defun remove-redundant (moves1 moves2)
  (cond
    ((null moves1) NIL)
    ((null moves2) moves1)
      ; returning a match
    ((is-redundant (car (list-only-states moves1)) (list-only-states moves2))
      (remove-redundant (cdr moves1) moves2)
    )
     ; is NOT match, need to remember car of moves1
   (t
   (cons (car moves1) (remove-redundant (cdr moves1) moves2))
   )
  )
)
; moves (state)
;check the position of e
;there is a finite set of possible moves from this position
;i.e If e is in row1, column1 it is therefore in INDEX 0
;     KNOWN MOVES are only D and R
;i.e If e is in row1, column2 it is therefore in INDEX 1
;     KNOWN MOVES are only D L and R
; ...
;i.e If e is in row3, column3 it is therefore at INDEX 8
;     KNOWN MOVES are only U and L
(defun moves (state)
  (case (position 'e state)
  (0 (list (moveDown 0 state) (moveRight 0 state)))
  (1 (list (moveDown 1 state) (moveLeft 1 state) (moveRight 1 state)))
  (2 (list (moveDown 2 state) (moveLeft 2 state)))
  (3 (list (moveUP 3 state) (moveDown 3 state) (moveRight 3 state)))
  (4 (list (moveUP 4 state) (moveDown 4 state) (moveLeft 4 state) (moveRight 4 state)))
  (5 (list (moveUP 5 state) (moveDown 5 state) (moveLeft 5 state)))
  (6 (list (moveUP 6 state) (moveRight 6 state)))
  (7 (list (moveUP 7 state) (moveLeft 7 state) (moveRight 7 state)))
  (8 (list (moveUP 8 state) (moveLeft 8 state)))
  )
)

;find-element-at-swap-position(index-of-swapee state)
;helper function for the 4 movement functions
;returns the element needing to be swapped with e
(defun find-element-at-swap-position (index-of-swapee state)
  (nth index-of-swapee state)
)

;swapfun(swapee state)
;swap function takes the element needed to be swapped with e
;(which was returned from find-element-at-swap-position function)
;and uses a nested substitute method to
;substitutes a temporary 'a in for e, an e in for the swapee,
;and finally the swapee for the temporary 'a
(defun swapfun (swapee state)
  (subst swapee 'a (subst 'e swapee (subst 'a 'e state)))
)

;moveLeft(index-of-e state)
;This function is accessed after KNOWING the index of e
;(this function is called directly from moves function)
;finds the swapee by calculating 1 index to the left of e,
;and passing that into the find-element-at-swap-position function
;then performing the swap
(defun moveLeft (index-of-e state)
    (list 'L
    (swapfun
      (find-element-at-swap-position (- (position 'e state) 1) state)
      state)
    )
)

;moveRight(index-of-e state)
;This function is accessed after KNOWING the index of e
;(this function is called directly from moves function)
;finds the swapee by calculating 1 index to the right of e,
;and passing that into the find-element-at-swap-position function
;then performing the swap
(defun moveRight (index-of-e state)
    (list 'R
    (swapfun
      (find-element-at-swap-position (+ (position 'e state) 1) state)
      state)
    )
)

;moveUp(index-of-e state)
;This function is accessed after KNOWING the index of e
;(this function is called directly from moves function)
;finds the swapee by calculating 3 indexes to the left of e,
;and passing that into the find-element-at-swap-position function
;then performing the swap
(defun moveUp (index-of-e state)
    (list 'U
    (swapfun
      (find-element-at-swap-position (- (position 'e state) 3) state)
      state)
    )
)

;moveDown(index-of-e state)
;This function is accessed after KNOWING the index of e
;(this function is called directly from moves function)
;finds the swapee by calculating 3 indexes to the right of e,
;and passing that into the find-element-at-swap-position function
;then performing the swap
(defun moveDown (index-of-e state)
    (list 'D
    (swapfun
      (find-element-at-swap-position (+ (position 'e state) 3) state)
      state)
    )
)


;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
;;;end of program puzzle;;;
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

                    ;addNIL
(defun make-open-init (initial-state)
  (list (list (list 'NIL initial-state)))
  )

(defun add-init-state (moves path)
 (cond
  ((null moves) NIL)
  (t
  (cons (cons (car moves) path)(add-init-state (cdr moves) path)))
  )
 )
                    ;extend-path
(defun extend-path (path)
  (add-init-state
  (remove-redundant (moves(car(list-only-states path))) path)
  path)
)

                    ;search-bfs
(defun search-bfs (open-list)
  (cond
    ((null open-list) NIL)
    ((goal-state (get-state (first (first open-list)))) (path (first open-list)))
    (t (search-bfs (append (cdr open-list) (extend-path (first open-list)))))
  )
)

                  ;seach-dfs-fd
(defun search-dfs-fd (open-list x)
  (cond
    ((null open-list) NIL)
    ((> (length (first open-list)) (+ x 1)) (search-dfs-fd (cdr open-list) x))
    ((goal-state (get-state (first (first open-list)))) (path (first open-list)))
    (t (search-dfs-fd (append (extend-path (first open-list)) (cdr open-list)) x))
  )
)

                ;search-id
(defun search-id (open-list &optional (x 1))
  (cond
    ((null open-list) NIL)
    ((null (search-dfs-fd open-list x)) (search-id open-list (+ x 1)))
    (t(search-dfs-fd open-list x))
  )
)

(defun sss (state &key (type 'BFS) (depth 7) (f #'out-of-place-f))
  (cond
    ((goal-state state) NIL)
    ((equal type 'BFS) (search-bfs (make-open-init state)))
    ((equal type 'DFS) (search-dfs-fd (make-open-init state) depth))
    ((equal type 'ID) (search-id (make-open-init state)))
    ((equal type 'A*) (search-a* (make-open-init state) f))
    (t NIL)
    )
)
;;;;;testing states;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

;(setq blah '((R (1 2 3 8 e 4 7 6 5)) (U (e 2 3 1 8 4 7 6 5)) (D (1 2 3 7 8 4 e 6 5))))
;(setq boo '((D (1 2 3 e 8 4 7 6 5)) (L (e 2 3 1 8 4 7 6 5)) (U (2 e 3 1 8 4 7 6 5)) (U (2 8 3 1 e 4 7 6 5))))
;(setq boo '((D (1 2 3 e 8 4 7 6 5)) (R (e 2 3 1 8 4 7 6 5)) (U (1 2 3 4 8 7 e 6 5)) (NIL (1 2 3 e 8 7 4 6 5))))

;(setq bug '(2 e 3 4 7 8 1 5 6))

;(setq e0 '(e 2 3 4 7 8 1 5 6))
;(setq e1 '(2 e 3 4 7 8 1 5 6))
;(setq e2 '(2 3 e 4 7 8 1 5 6))
;(setq e3 '(2 3 4 e 7 8 1 5 6))
;(setq e4 '(2 3 4 7 e 8 1 5 6))
;(setq e5 '(2 3 4 7 8 e 1 5 6))
;(setq e6 '(2 3 4 7 8 1 e 5 6))
;(setq e7 '(2 3 4 7 8 1 5 e 6))
;(setq e8 '(2 3 4 7 8 1 5 6 e))
;(setq instate '(2 8 3 1 6 4 7 e 5))

;(setq ext (first(make-open-init instate)))
;(setq test-path (first (extend-path (first (make-open-init instate)))))
;(setq try (extend-path test-path))
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;


;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
;;;;searching and heuristics;;;;;;
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

;(setq this '(1 2 3 8 e 4 7 6 5))
;(setq that '(2 8 3 1 6 4 7 e 5))

;(setq probe1 '((U (2 8 3 1 e 4 7 6 5)) (NIL (2 8 3 1 6 4 7 e 5))))
;(setq probe2 '((U (1 2 3 8 6 e 7 5 4)) (NIL (1 2 3 8 6 4 7 5 e))))
;(setq probe3 '((L (2 1 4 8 e 7 3 6 5)) (NIL (1 2 4 8 7 e 3 6 5))))

;(setq probe '(2 8 1 e 6 3 7 5 4))

;(setq (extend-path (first (make-open-init probe))))

;(setq open-list-ex '(((U (2 e 3 1 8 4 7 6 5)) (NIL (2 8 3 1 e 4 7 6 5)))((D (2 8 3 1 6 4 7 e 5)) (NIL (2 8 3 1 e 4 7 6 5)))((L (2 8 3 e 1 4 7 6 5)) (NIL (2 8 3 1 e 4 7 6 5)))((R (2 8 e 1 4 e 7 6 5)) (NIL (2 8 3 1 e 4 7 6 5)))))

(defun out-of-place (state &optional (goal '(1 2 3 8 e 4 7 6 5)) (count 0))
  (cond
    ((null state) count)
    ((goal-state state) '0)
    ((equal (car state) (car goal)) (out-of-place (cdr state) (cdr goal) (+ count 0)))
    ((equal (car goal) 'e) (out-of-place (cdr state) (cdr goal) (+ count 0)))
    (t (out-of-place (cdr state) (cdr goal) (+ count 1))
    )
  )
)

(defun out-of-place-f (path)
(+ (out-of-place (get-state (first path))) (length (path path)))
)

          ;manhattan
(defun manhattan-focused-on (x state)
  (case x
    ('e 0)
    (1 (manhattan-calculate-distance-from-goal (position '1 state) 0 state))
    (2 (manhattan-calculate-distance-from-goal (position '2 state) 1 state))
    (3 (manhattan-calculate-distance-from-goal (position '3 state) 2 state))
    (8 (manhattan-calculate-distance-from-goal (position '8 state) 3 state))
    (4 (manhattan-calculate-distance-from-goal (position '4 state) 5 state))
    (7 (manhattan-calculate-distance-from-goal (position '7 state) 6 state))
    (6 (manhattan-calculate-distance-from-goal (position '6 state) 7 state))
    (5 (manhattan-calculate-distance-from-goal (position '5 state) 8 state))
  )
)

(defun manhattan-calculate-distance-from-goal (index-of-number goal-index state)
  (case goal-index
    (0 (case index-of-number
          (0 0)
          (1 1)
          (2 2)
          (3 1)
          (4 2)
          (5 3)
          (6 2)
          (7 3)
          (8 4)
          )
    )
    (1 (case index-of-number
          (0 1)
          (1 0)
          (2 1)
          (3 2)
          (4 1)
          (5 2)
          (6 3)
          (7 2)
          (8 3)
          )
    )
    (2 (case index-of-number
          (0 2)
          (1 1)
          (2 0)
          (3 3)
          (4 2)
          (5 1)
          (6 4)
          (7 3)
          (8 2)
          )
    )
    (3 (case index-of-number
          (0 1)
          (1 2)
          (2 3)
          (3 0)
          (4 1)
          (5 2)
          (6 1)
          (7 1)
          (8 3)
          )
    )
    (5 (case index-of-number
          (0 3)
          (1 2)
          (2 1)
          (3 2)
          (4 1)
          (5 0)
          (6 3)
          (7 2)
          (8 1)
          )
    )
    (6 (case index-of-number
          (0 2)
          (1 3)
          (2 4)
          (3 1)
          (4 2)
          (5 3)
          (6 0)
          (7 1)
          (8 2)
          )
    )
    (7 (case index-of-number
          (0 3)
          (1 2)
          (2 3)
          (3 2)
          (4 1)
          (5 2)
          (6 1)
          (7 0)
          (8 1)
          )
    )
    (8 (case index-of-number
          (0 4)
          (1 3)
          (2 2)
          (3 3)
          (4 2)
          (5 1)
          (6 2)
          (7 1)
          (8 0)
          )
    )
  )
)


(defun manhattan-helper (state walk-through-state count)
(cond
((null state) count)
(t (manhattan-helper (cdr state) walk-through-state (+ count (manhattan-focused-on (car state) walk-through-state))))))

(defun manhattan (state)
  (manhattan-helper state state 0)
)

(defun manhattan-f (path)
  (+ (manhattan (get-state (first path)))(length (path path)))
)

(defun better (f)
    (lambda (path1 path2)
      (<= (funcall f path1) (funcall f path2))
    )
)


(defun search-a* (open-list evalfunc)
    (cond
      ((null open-list) NIL)
      ((goal-state (get-state (first (first open-list)))) (path (first open-list)))
      (t (search-a* (sort (append (cdr open-list) (extend-path (first open-list))) (better evalfunc)) evalfunc)
      )
    )
)

;(sort (extend-path (first open-list-ex)) (better #'out-of-place-f))
