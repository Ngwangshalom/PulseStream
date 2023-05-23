Module MainModule
    sub Main()
        Dim User As String
        Dim Admin As String
        Dim SuperAdmin As String
        Dim Number As Integer
        User = "User"
        Admin = "Admin"
        SuperAdmin = "SuperAdmin"
        Number = 33

    Console.WriteLine("Please enter your Level\n")
    Dim Position As String = Console.ReadLine()

    if(Position === User){
        Console.WriteLine("You are a," & User & " with Number of" &Number)
    }elseif(Position === Admin){
        Console.WriteLine("You are an," &Admin & "with number of" &Number)
    }
    else{
         Console.WriteLine("You are a," &SuperAdmin & "with number of" &Number)

    }

    Console.ReadLine()
    End Main
    End MainModule