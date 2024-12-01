import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Register2 extends StatelessWidget {
  final TextEditingController nameController = TextEditingController();
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  // Function to save user details
  Future<void> saveUserDetails(String name, String email, String password) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.setString('user_name', name);
    await prefs.setString('user_email', email);
    await prefs.setString('user_password', password);
    print('User details saved: $name, $email');
  }

  // Function to retrieve user details
  Future<Map<String, String?>> getUserDetails() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? name = prefs.getString('user_name');
    String? email = prefs.getString('user_email');
    String? password = prefs.getString('user_password');
    return {'name': name, 'email': email, 'password': password};
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: SingleChildScrollView(
          child: Padding(
            padding: const EdgeInsets.all(20.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                const Text(
                  'Register User',
                  style: TextStyle(
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 30),
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
                const SizedBox(height: 30),
                ElevatedButton(
                  onPressed: () {
                    String name = nameController.text.trim();
                    String email = emailController.text.trim();
                    String password = passwordController.text.trim();

                    if (name.isNotEmpty && email.isNotEmpty && password.isNotEmpty) {
                      saveUserDetails(name, email, password);
                      ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(content: Text('User details saved successfully!')),
                      );
                    } else {
                      ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(content: Text('Please fill all fields')),
                      );
                    }
                  },
                  style: ElevatedButton.styleFrom(
                    minimumSize: const Size(200, 60),
                    textStyle: const TextStyle(fontSize: 18),
                  ),
                  child: const Text('Register'),
                ),
                const SizedBox(height: 20),
                ElevatedButton(
                  onPressed: () async {
                    Map<String, String?> userDetails = await getUserDetails();
                    showDialog(
                      context: context,
                      builder: (context) {
                        return AlertDialog(
                          title: const Text('Saved User Details'),
                          content: Text(
                            'Name: ${userDetails['name'] ?? 'Not registered'}\n'
                            'Email: ${userDetails['email'] ?? 'Not registered'}',
                          ),
                          actions: [
                            TextButton(
                              onPressed: () {
                                Navigator.of(context).pop();
                              },
                              child: const Text('OK'),
                            ),
                          ],
                        );
                      },
                    );
                  },
                  style: ElevatedButton.styleFrom(
                    minimumSize: const Size(200, 60),
                    textStyle: const TextStyle(fontSize: 18),
                  ),
                  child: const Text('Retrieve User Details'),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
