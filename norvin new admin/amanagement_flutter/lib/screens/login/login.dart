import 'package:amanagement_flutter/screens/home.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:amanagement_flutter/screens/register/register1.dart';

import '../../utils/https.dart'; // Import Register1 screen

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  bool isLoading = false;
  String? emailError;
  String? passwordError;

  Future<void> loginUser(BuildContext context) async {
    String email = emailController.text.trim();
    String password = passwordController.text.trim();

    // Reset error messages
    setState(() {
      emailError = null;
      passwordError = null;
    });

    // Validate fields
    if (email.isEmpty) {
      setState(() {
        emailError = 'Email is required';
      });
    } else if (!RegExp(r"^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$").hasMatch(email)) {
      setState(() {
        emailError = 'Invalid email format';
      });
    }

    if (password.isEmpty) {
      setState(() {
        passwordError = 'Password is required';
      });
    }

    if (email.isNotEmpty && password.isNotEmpty && emailError == null) {
      setState(() {
        isLoading = true;
      });

      try {
        ApiService apiService = ApiService();
        final response = await apiService.loginUser(email, password);

        if (response != null && response.success) {
          // Save the token and user data in SharedPreferences
          SharedPreferences prefs = await SharedPreferences.getInstance();
          await prefs.setString('user_token', response.token ?? '');
          await prefs.setString('user_email', email);

          setState(() {
            isLoading = false;
          });

          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Login successful!')),
          );

          // Extract user details from the response
          final user = response.user;
          final token = response.token;
          final userId = user?['id'];
          final name = user?['name'];

          // Navigate to HomeScreen and pass the values
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (context) => HomeScreen(
                token: token ?? '',
                userId: userId,
                email: email,
                name: name,
              ),
            ),
          );
        } else {
          setState(() {
            isLoading = false;
          });
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Login failed: ${response?.message ?? 'Unknown error'}')),
          );
        }
      } catch (e) {
        setState(() {
          isLoading = false;
        });
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Login failed: $e')),
        );
      }
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Please fill all fields correctly')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false, 
        title: const Text('Login'),
      ),
      body: Stack(
        children: [
          SingleChildScrollView(
            padding: const EdgeInsets.all(20.0),
            child: Column(
              children: [
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
                  onPressed: () => loginUser(context),
                  style: ElevatedButton.styleFrom(
                    minimumSize: const Size.fromHeight(50),
                  ),
                  child: const Text('Login'),
                ),
                const SizedBox(height: 20),
                GestureDetector(
                  onTap: () {
                    // Navigate to Register screen
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => Register1()),
                    );
                  },
                  child: const Text(
                    "Don't have an account? Register Here",
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
