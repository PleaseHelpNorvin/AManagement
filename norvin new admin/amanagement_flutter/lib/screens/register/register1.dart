import 'package:amanagement_flutter/screens/home.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:amanagement_flutter/screens/register/register2.dart'; // Import Register2
import 'package:amanagement_flutter/screens/login/login.dart'; // Import Login
import 'package:amanagement_flutter/utils/https.dart'; // Import API Service

class Register1 extends StatefulWidget {
  @override
  _Register1State createState() => _Register1State();
}

class _Register1State extends State<Register1> {
  final TextEditingController nameController = TextEditingController();
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  bool isLoading = false; // To manage loading state
  String? nameError;
  String? emailError;
  String? passwordError;

  @override
  void initState() {
    super.initState();
    _checkUserDetails();
  }

  // Check if the user details are already saved in SharedPreferences
  Future<void> _checkUserDetails() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? savedName = prefs.getString('user_name');
    String? savedEmail = prefs.getString('user_email');
    String? savedPassword = prefs.getString('user_password');
    String? savedToken = prefs.getString('user_token');
    int? savedUserId = prefs.getInt('user_id'); // Get the userId as an integer

    if (savedToken != null && savedName != null && savedEmail != null && savedPassword != null && savedUserId != null) {
      // User details are already saved, navigate directly to the next screen (Register2)
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (context) => HomeScreen(
            userId: savedUserId, // Pass the saved userId
            email: savedEmail,
            name: savedName,
            token: savedToken,
          ),
        ),
      );
    }
  }

  // Function to save user details locally (optional)
  Future<void> saveUserDetails(String name, String email, String password, int userId, String token) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.setString('user_name', name);
    await prefs.setString('user_email', email);
    await prefs.setString('user_password', password);
    await prefs.setInt('user_id', userId);
    await prefs.setString('user_token', token);

    print('User details saved locally: $name, $email, $userId , $token');
  }

  // Function to handle registration
  Future<void> register(BuildContext context) async {
    String name = nameController.text.trim();
    String email = emailController.text.trim();
    String password = passwordController.text.trim();

    setState(() {
      nameError = null;
      emailError = null;
      passwordError = null;
    });

    if (name.isEmpty) {
      setState(() {
        nameError = 'Name is required';
      });
    }
    if (email.isEmpty) {
      setState(() {
        emailError = 'Email is required';
      });
    }
    if (password.isEmpty) {
      setState(() {
        passwordError = 'Password is required';
      });
    }

    if (name.isNotEmpty && email.isNotEmpty && password.isNotEmpty) {
      setState(() {
        isLoading = true; // Show loading indicator
      });

      ApiService apiService = ApiService();
      final response = await apiService.registerUser(name, email, password); // Call registerUser API

      setState(() {
        isLoading = false; // Hide loading indicator
      });

      if (response != null && response.success) {
        int userId = response.user?['id'] ?? 0; // Safely accessing nested user ID
        String token = response.token ?? '';

        await saveUserDetails(name, email, password, userId, token);

        // Show success message
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Registration successful: ${response.message}')),
        );

        // Navigate to Register2 page, passing the userId, email, and name
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(
            builder: (context) => Register2(
              userId: userId,
              email: email,
              name: name,
              token: token,
            ),
          ),
        );
      } else {
        // Handle API failure with a specific message
        String errorMessage = response?.message ?? 'Registration failed: Please try again.';
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(errorMessage)),
        );
      }
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Please fill all fields')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false, 
        title: const Text('Register'),
      ),
      body: Stack(
        children: [
          SingleChildScrollView(
            padding: const EdgeInsets.all(20.0),
            child: Column(
              children: [
                const SizedBox(height: 40),
                TextField(
                  controller: nameController,
                  decoration: InputDecoration(
                    labelText: 'Name',
                    border: const OutlineInputBorder(),
                    errorText: nameError,
                  ),
                ),
                const SizedBox(height: 40),
                TextField(
                  controller: emailController,
                  decoration: InputDecoration(
                    labelText: 'Email',
                    border: const OutlineInputBorder(),
                    errorText: emailError,
                  ),
                ),
                const SizedBox(height: 40),
                TextField(
                  controller: passwordController,
                  decoration: InputDecoration(
                    labelText: 'Password',
                    border: const OutlineInputBorder(),
                    errorText: passwordError,
                  ),
                  obscureText: true,
                ),
                const SizedBox(height: 20),
                ElevatedButton(
                  onPressed: () => register(context),
                  style: ElevatedButton.styleFrom(
                    minimumSize: const Size.fromHeight(50),
                  ),
                  child: const Text('Register'),
                ),
                const SizedBox(height: 20),
                GestureDetector(
                  onTap: () {
                    // Navigate to Login screen
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => LoginScreen()),
                    );
                  },
                  child: const Text(
                    "Already have an account? Login Here",
                    style: TextStyle(
                      color: Colors.blue,
                      decoration: TextDecoration.underline,
                    ),
                  ),
                ),
              ],
            ),
          ),
          if (isLoading)
            const Center(
              child: CircularProgressIndicator(),
            ),
        ],
      ),
    );
  }
}
