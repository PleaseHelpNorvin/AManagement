import 'package:amanagement_flutter/pages/signup.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'login.dart';  // Assuming your Login page is named Login.dart

class FirstTimePage extends StatelessWidget {
  const FirstTimePage({Key? key}) : super(key: key);

  Future<void> _setFirstTimeFlag() async {
    final prefs = await SharedPreferences.getInstance();
    prefs.setBool('isFirstTimeUser', false);  // Set to false after the first-time screen
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Welcome to AManagement'),
      ),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              const Text(
                'Welcome to the AManagement App!',
                style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 20),
              const Text(
                'This app will help you manage your tasks and keep track of your important data. Get started by logging in!',
                textAlign: TextAlign.center,
                style: TextStyle(fontSize: 16),
              ),
              const SizedBox(height: 40),
              ElevatedButton(
                onPressed: () async {
                  await _setFirstTimeFlag(); // Set the flag
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (context) => const Signup()),
                  );
                },
                child: const Text('Get Started'),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
