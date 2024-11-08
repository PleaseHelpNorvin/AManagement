import 'package:flutter/material.dart';
import '../utils/httpmethods.dart'; // Assumed API method
import '../pages/Clientdatasignup.dart'; // Ensure this import is correct

class Signup extends StatefulWidget {
  const Signup({super.key});

  @override
  State<Signup> createState() => _SignupState();
}

class _SignupState extends State<Signup> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  final TextEditingController _controllerUsername = TextEditingController();
  final TextEditingController _controllerEmail = TextEditingController();
  final TextEditingController _controllerPassword = TextEditingController();
  final TextEditingController _controllerConFirmPassword = TextEditingController();
  bool _obscurePassword = true;

  void _registerUser() async {
    if (_formKey.currentState?.validate() ?? false) {
      try {
        final response = await registerUser(
          _controllerUsername.text,
          _controllerEmail.text,
          _controllerPassword.text,
        );

        if (response != null && response.token.isNotEmpty) {
          // If the registration was successful, navigate to the next page
          final token = response.token;
          final userId = response.userInfo.id;

          Navigator.push(
            context,
            MaterialPageRoute(
              builder: (acontext) => ClientDataSignup(
                username: _controllerUsername.text,
                token: token,
                userId: userId,
              ),
            ),
          );
        } else {
          // If registration failed, show an error message
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Failed to register user.')),
          );
        }
      } catch (e) {
        print('Error during registration: $e');
        // Show an error message if something goes wrong
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Error: $e')),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Form(
        key: _formKey,
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 30.0),
          child: Column(
            children: [
              const SizedBox(height: 100),
              const Text("Register", style: TextStyle(fontSize: 24)),
              const SizedBox(height: 35),
              TextFormField(
                controller: _controllerUsername,
                decoration: InputDecoration(
                  labelText: "Username",
                  prefixIcon: const Icon(Icons.person_outline),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return "Please enter username.";
                  }
                  return null;
                },
              ),
              const SizedBox(height: 10),
              TextFormField(
                controller: _controllerEmail,
                decoration: InputDecoration(
                  labelText: "Email",
                  prefixIcon: const Icon(Icons.email_outlined),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty || !value.contains('@')) {
                    return "Invalid email";
                  }
                  return null;
                },
              ),
              const SizedBox(height: 10),
              TextFormField(
                controller: _controllerPassword,
                obscureText: _obscurePassword,
                decoration: InputDecoration(
                  labelText: "Password",
                  prefixIcon: const Icon(Icons.password_outlined),
                  suffixIcon: IconButton(
                    onPressed: () {
                      setState(() {
                        _obscurePassword = !_obscurePassword;
                      });
                    },
                    icon: _obscurePassword
                        ? const Icon(Icons.visibility_outlined)
                        : const Icon(Icons.visibility_off_outlined),
                  ),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty || value.length < 8) {
                    return "Password must be at least 8 characters.";
                  }
                  return null;
                },
              ),
              const SizedBox(height: 10),
              TextFormField(
                controller: _controllerConFirmPassword,
                obscureText: _obscurePassword,
                decoration: InputDecoration(
                  labelText: "Confirm Password",
                  prefixIcon: const Icon(Icons.password_outlined),
                ),
                validator: (value) {
                  if (value == null || value != _controllerPassword.text) {
                    return "Passwords don't match.";
                  }
                  return null;
                },
              ),
              const SizedBox(height: 50),
              ElevatedButton(
                onPressed: _registerUser,
                child: const Text("Register"),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
