import 'package:amanagement_mobile/utils/https.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../../models/register.dart'; // Import the registerUser function
import '../register/register2.dart';

class Register1 extends StatefulWidget {
  @override
  _Register1State createState() => _Register1State();
}

class _Register1State extends State<Register1> {
  final TextEditingController nameController = TextEditingController();
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  bool isLoading = false; // To manage loading state

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
    int? savedUserId = prefs.getInt('user_id'); // Change to get the userId as an integer

    if (savedToken != null && savedName != null && savedEmail != null && savedPassword != null && savedUserId != null) {
      // User details are already saved, navigate directly to the next screen (Register2)
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (context) => Register2(
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

    if (name.isNotEmpty && email.isNotEmpty && password.isNotEmpty) {
      setState(() {
        isLoading = true; // Show loading indicator
      });

      // Create an instance of ApiService to call registerUser
      ApiService apiService = ApiService();
      final response = await apiService.registerUser(name, email, password); // Use the instance

      setState(() {
        isLoading = false; // Hide loading indicator
      });

      if (response != null && response.success) {
        // Save user details locally if needed
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
              userId: userId, // Pass the userId
              email: email,
              name: name,
              token: token,
            ),
          ),
        );
      } else {
        // Handle API failure with specific message
        String errorMessage = response?.message ?? 'Registration failed: Please try again.';
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(errorMessage)),
        );
      }
    } else {
      // Show validation error
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Please fill all fields')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Register User'),
      ),
      body: Stack(
        children: [
          SingleChildScrollView(
            padding: const EdgeInsets.all(20.0),
            child: Column(
              children: [
                const SizedBox(height: 20),
                TextField(
                  controller: nameController,
                  decoration: const InputDecoration(
                    labelText: 'Name',
                    border: OutlineInputBorder(),
                  ),
                ),
                const SizedBox(height: 20),
                TextField(
                  controller: emailController,
                  decoration: const InputDecoration(
                    labelText: 'Email',
                    border: OutlineInputBorder(),
                  ),
                ),
                const SizedBox(height: 20),
                TextField(
                  controller: passwordController,
                  decoration: const InputDecoration(
                    labelText: 'Password',
                    border: OutlineInputBorder(),
                  ),
                  obscureText: true,
                ),
              ],
            ),
          ),
          if (isLoading)
            const Center(
              child: CircularProgressIndicator(), // Show loading indicator
            ),
          Align(
            alignment: Alignment.bottomCenter,
            child: Padding(
              padding: const EdgeInsets.all(20.0),
              child: ElevatedButton(
                onPressed: () => register(context), // Call the register function
                style: ElevatedButton.styleFrom(
                  minimumSize: const Size.fromHeight(60), // Makes the button full width
                  textStyle: const TextStyle(fontSize: 18),
                ),
                child: const Text('Register'),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
