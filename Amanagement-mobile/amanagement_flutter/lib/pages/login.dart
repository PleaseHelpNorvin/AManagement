import 'package:flutter/material.dart';
import 'package:hive_flutter/hive_flutter.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import '../pages/home.dart'; // Update this import based on your project structure
import '../utils/httpmethods.dart'; // Assuming this contains the method for making the API call
import '../pages/signup.dart'; // Assuming you have a signup page

class Login extends StatefulWidget {
  const Login({Key? key}) : super(key: key);

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  final GlobalKey<FormState> _formKey = GlobalKey();
  final FocusNode _focusNodePassword = FocusNode();
  final TextEditingController _controllerUsername = TextEditingController();
  final TextEditingController _controllerPassword = TextEditingController();
  bool _obscurePassword = true;
  bool _isLoading = false; // Loading state variable

  late String storedToken;
  late String storedUserId;

  @override
  void initState() {
    super.initState();

    // Initialize Hive and retrieve the stored token and userId
    _initializeHive();
  }

  Future<void> _initializeHive() async {
    await Hive.initFlutter();
    await Hive.openBox('accounts'); // Open the 'accounts' box

    final Box box = Hive.box('accounts');
    storedToken = box.get('token', defaultValue: '');
    storedUserId = box.get('userId', defaultValue: '');

    // Debugging: print stored token and userId
    print('Stored Token: $storedToken');
    print('Stored UserId: $storedUserId');
  }

  Future<void> _submitLogin() async {
    if (_formKey.currentState?.validate() ?? false) {
      setState(() {
        _isLoading = true;
      });

      final username = _controllerUsername.text;
      final password = _controllerPassword.text;

      // Assuming login API is defined in your httpmethods.dart
      try {
        final response = await loginUser(username, password); // Make your login request here
        final responseBody = json.decode(response.body);
        print('Login response body: $responseBody'); // Debugging: print the response body

        if (response.statusCode == 200) {
          // Extract token and user info from the response
          final authToken = responseBody['token'] ?? '';
          final userId = responseBody['client_info']['user_id'] ?? '';

          // Store token and user info in Hive
          await Hive.box('accounts').put('token', authToken);
          await Hive.box('accounts').put('userId', userId);

          // Navigate to the Home page after successful login
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (context) => Home(
                username: username,
                clientData: json.encode({
                  'username': username,
                  'token': authToken,
                  'user_id': userId,
                  'user_info': {
                    'id': userId,
                    'username': username,
                    'email': responseBody['email'].toString(),
                    'email_verified_at': responseBody['email_verified_at'].toString(),
                    'created_at': responseBody['created_at'].toString(),
                    'updated_at': responseBody['updated_at'].toString(),
                    'role': responseBody['role'].toString(),
                    'is_logged_in': 1,
                    'last_active_at': responseBody['last_active_at'].toString(),
                  },
                  'client_info': {
                    'id': responseBody['client_info']['id'].toString(),
                    'user_id': userId,
                    'name': responseBody['client_info']['name'].toString(),
                    'middlename': responseBody['client_info']['middlename'].toString(),
                    'lastname': responseBody['client_info']['lastname'].toString(),
                    'gender': responseBody['client_info']['gender'].toString(),
                    'address': responseBody['client_info']['address'].toString(),
                    'contact_number': responseBody['client_info']['contact_number'].toString(),
                    'created_at': responseBody['client_info']['created_at'].toString(),
                    'updated_at': responseBody['client_info']['updated_at'].toString(),
                  },
                }),
              ),
            ),
          );
        } else {
          _showErrorSnackBar('Login failed: ${response.body}');
        }
      } catch (e) {
        // Handle any errors here
        _showErrorSnackBar("An error occurred: $e");
        print('Login error: $e');
      } finally {
        setState(() {
          _isLoading = false;
        });
      }
    }
  }

  void _showErrorSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text(message)),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).colorScheme.primaryContainer,
      body: Form(
        key: _formKey,
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(30.0),
          child: Column(
            children: [
              const SizedBox(height: 150),
              Text(
                "Welcome back",
                style: Theme.of(context).textTheme.headlineLarge,
              ),
              const SizedBox(height: 10),
              Text(
                "Login to your account",
                style: Theme.of(context).textTheme.bodyMedium,
              ),
              const SizedBox(height: 60),
              TextFormField(
                controller: _controllerUsername,
                keyboardType: TextInputType.name,
                decoration: InputDecoration(
                  labelText: "Username",
                  prefixIcon: const Icon(Icons.person_outline),
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
                onEditingComplete: () => _focusNodePassword.requestFocus(),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return "Please enter username.";
                  }
                  return null;
                },
              ),
              const SizedBox(height: 10),
              TextFormField(
                controller: _controllerPassword,
                focusNode: _focusNodePassword,
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
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return "Please enter password.";
                  }
                  return null;
                },
              ),
              const SizedBox(height: 50),
              _isLoading
                  ? const Center(child: CircularProgressIndicator())
                  : ElevatedButton(
                      style: ElevatedButton.styleFrom(
                        minimumSize: const Size.fromHeight(50),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(20),
                        ),
                      ),
                      onPressed: _submitLogin,
                      child: _isLoading
                          ? const CircularProgressIndicator()
                          : const Text("Login"),
                    ),
              const SizedBox(height: 20),
              GestureDetector(
                onTap: () {
                  // Navigate to the signup page
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => const Signup()),
                  );
                },
                child: Text(
                  "Don't have an account? Sign up here.",
                  style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                        color: Theme.of(context).colorScheme.secondary,
                        fontWeight: FontWeight.bold,
                      ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
