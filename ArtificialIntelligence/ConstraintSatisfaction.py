# Breanna Caggiano and Carlyn Marshall
# CSCI 450
# Due date: May 5th, 2017
# Constraint Satisfaction problem

from z3 import *

# list_of_output : is an array that will hold the appropriate output
# the output for this specific problem will be a list of the minimum number of
#  committees required to satisfy the constraints provided by the user
list_of_output = []
# list_of_bad_pairs_Left : is an array that holds the first person in a pair that
#  is in a constrained relationship
list_of_bad_pairs_Left = []
# list_of_bad_pairs_Right : is an array that hold the second person in a pair involved
#  in a constrained relationship
list_of_bad_pairs_Right = []

# output(number, a) : is a method that will print the program's output, one number on
#  each line
#  number : The first parameter passed into the output() function represents the
#    minuimum number of committees that satisfies the identified constraints
#  a : When the second parameter passed into the output() function == 1,
#    the program finishes immediately after the output to the console is displayed
#    else, the list_of_output array will now contain one more number to display when
#    the user indicates the end of the program
def output(number, a):
    if a == 1:
        print(*list_of_output, sep='\n')
    else:
        list_of_output.append(number)

# get_input() : is the function that will gather the input from the user
# buckets : the only variable that gets passed into the get_input() function
#    this variable keeps track of the minimum number of committees used to try and
#    satisfy all of the given constraints
# This function will check if the user's input is 0 0, which is the specific
#  value to be entered in order to  call output() and output the results
#  and end the program
# This function calls calculations() and passes the total number of people as n, the
#  number of pairs that have constraints as m, and the current value of committes that
#  attempt to solve the problem as buckets
def get_input(buckets):
    user_input = input();
    n,m = user_input.split(" ")
    n = int(n)
    m = int(m)
    if n == 0 and m == 0:
        output(0,1)
    else:
        calculations(n,m,buckets)

# calculations(n,m,buckets) : is the function that will calculate what the minimum
#  of committeees is needed an order to satisy all of the constraints provided by the
#  user's input
#  n : is a total number of people
#  m : is the number of pairs with constraints
# buckets : this variable keeps track of the minimum number of committees used to
#   try and satisfy all of the given constraints
def calculations(n, m, buckets):
    # set up for z3 Solver
    f = Function('f', IntSort(), IntSort())
    s = z3.Solver()
    s.push()
    # In the first round of calculations(), therefore, need to grab the input pairs
    if buckets == 1:
        # prompt the user for input for homwever many pairs there will be that have
        #  constraints
        # Grab all of the pairs, appending the number that identifies each person
        #  in the pair to the list of constrained pairs
        for x in range(1, m+1):
            user_input = input();
            n1,n2 = user_input.split(" ")
            n1 = int(n1)
            list_of_bad_pairs_Left.append(n1)
            n2 = int(n2)
            list_of_bad_pairs_Right.append(n2)
            # constrain the function to assign these people different committees
            s.add(f(n1) != f(n2))
            # constrain each person to only be assigned to 1 committee
            for x in range(1, n+1):
                s.add(f(x) >= 1, f(x) <= 1)
    # In a recursed calculations(), No need to grab user input
    else:
        s.push()
        # add constraints for each pair, the total number of pairs is specified by m
        for x in range(0, m):
            s.add(f(list_of_bad_pairs_Left[x]) != f(list_of_bad_pairs_Right[x]))
        # constrain each person to only be assigned to 1 committee and the
        #  current value of buckets, which increases by one with each recursive call
        for x in range(1, n+1):
            s.add(f(x) >= 1, f(x) <= buckets)
    # z3 Solver will determine if all of the added constraints can be satisfied
    if s.check() == z3.sat:
                            #print ("Satisfiable!")
                            #print ("Here is the model: ", s.model())
        list_of_bad_pairs_Left.clear()
        list_of_bad_pairs_Right.clear()
        # add the minimum number of committees, buckets, to the list_of_output
        #  do not end the program (the user must type 0 0 in order to end the program)
        output(buckets, 0)
        # start fresh
        get_input(1)
    # the current value of buckets will not satisfy all of the specified constraints
    # Recurse this function with an additional committee
    else:
        calculations(n,m,buckets+1)
    s.pop()

#START_HERE!!!!!!!!!!!!
get_input(1)
