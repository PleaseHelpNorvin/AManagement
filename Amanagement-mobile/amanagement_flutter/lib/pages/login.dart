import 'package:amanagement_flutter/pages/isfirsttime.dart';
import 'package:amanagement_flutter/pages/signup.dart';
import 'package:amanagement_flutter/utils/sharedpreferenceservice.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import '../pages/home.dart'; // Update this import based on your project structure
import '../utils/httpmethods.dart'; // Assuming this contains the method for making the API call

class Login extends StatefulWidget {
  const Login({Key? key}) : super(key: key);

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  final GlobalKey<FormState> _formKey = GlobalKey();
  final TextEditingController _controllerUsername = TextEditingController();
  final TextEditingController _controllerPassword = TextEditingController();
  bool _obscurePassword = true;
  bool _isLoading = false; // Loading state variable

  Future<void> _checkFirstTimeUser() async {
    final prefs = await SharedPreferences.getInstance();
    final isFirstTimeUser = prefs.getBool('isFirstTimeUser') ?? true;

    if (isFirstTimeUser) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => const FirstTimePage()),
      );
    }
  }

  @override
  void initState() {
    super.initState();
  }

  Future<void> _submitLogin() async {
    if(_formKey.currentState?.validate() ?? false) {
      try{
        final response = await loginUser(
          _controllerUsername.text,
          _controllerPassword.text,
        );

        if(response != null && response.token.isNotEmpty) {
          final token = response.token;
          final userInfo = response.userInfo;
          final clientInfo = response.clientInfo;
          // final/

          print('Logged in successfully with token: $token');

            SharedPreferencesService().saveUserDataToPrefs(
              token,
              userInfo,
              clientInfo,
              userInfo.isLoggedIn, // Assuming isLoggedIn is a field in userInfo
            );

          Navigator.pushReplacement(
            context, 
            MaterialPageRoute
            (builder: (context) => Home(
               
              userId: response.clientInfo.userId,
              token: response.token,
              userInfo: userInfo,
              clientInfo: clientInfo,
              isLoggedIn: userInfo.isLoggedIn
            )),
          );
        }else{
          print('no token ');
        }
       

      } catch (e) {
        print('Error during Login: $e');
      }
    } 
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Login'),
      ),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Form(
            key: _formKey,
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                TextFormField(
                  controller: _controllerUsername,
                  decoration: const InputDecoration(labelText: 'Username'),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please enter your username';
                    }
                    return null;
                  },
                ),
                TextFormField(
                  controller: _controllerPassword,
                  obscureText: _obscurePassword,
                  decoration: InputDecoration(
                    labelText: 'Password',
                    suffixIcon: IconButton(
                      icon: Icon(
                        _obscurePassword ? Icons.visibility_off : Icons.visibility,
                      ),
                      onPressed: () {
                        setState(() {
                          _obscurePassword = !_obscurePassword;
                        });
                      },
                    ),
                  ),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please enter your password';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 20),
                _isLoading
                ? CircularProgressIndicator()
                : ElevatedButton(
                    onPressed: _submitLogin,
                    child: const Text('Login'),
                  ),
                const SizedBox(height: 30),
                  Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  const Text("Don't have an account? "),
                  TextButton(
                    onPressed: () {
                      // Navigate to the Signup page
                      Navigator.pushReplacement(
                        context,
                        MaterialPageRoute(builder: (context) => Signup()),
                      );
                    },
                    child: const Text("Sign Up Here"),
                  ),
                ],
              ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
