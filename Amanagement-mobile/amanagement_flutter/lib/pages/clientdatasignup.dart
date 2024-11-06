import 'package:flutter/material.dart';
import 'package:hive_flutter/hive_flutter.dart';
import 'package:http/http.dart';
import 'dart:convert';
import '../utils/httpmethods.dart'; // Assumed API method
import '../pages/home.dart';

class ClientDataSignup extends StatefulWidget {
  final String username;
  final String token;
  final String userId;

  const ClientDataSignup({
    Key? key,
    required this.username,
    required this.token,
    required this.userId,
  }) : super(key: key);

  @override
  State<ClientDataSignup> createState() => _ClientSignupState();
}

class _ClientSignupState extends State<ClientDataSignup> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  final TextEditingController _controllerName = TextEditingController();
  final TextEditingController _controllerMiddleName = TextEditingController();
  final TextEditingController _controllerLastName = TextEditingController();
  final TextEditingController _controllerAddress = TextEditingController();
  final TextEditingController _controllerContactNumber = TextEditingController();
  String? _selectedGender;

  late String storedToken;
  late String storedUserId;

  @override
  void initState() {
    super.initState();
    // Retrieve the stored token and userId from Hive
    final Box box = Hive.box('accounts');
    storedToken = box.get('token', defaultValue: '');
    storedUserId = box.get('userId', defaultValue: '');
    // Debugging stored token and user ID
    print('Stored Token: $storedToken');
    print('Stored UserId: $storedUserId');
  }

  bool hasNullValues() {
    final clientData = {
      'username': widget.username,
      'name': _controllerName.text,
      'middlename': _controllerMiddleName.text,
      'lastname': _controllerLastName.text,
      'gender': _selectedGender,
      'address': _controllerAddress.text,
      'contact_number': _controllerContactNumber.text,
      'user_id': widget.userId,
    };
    // Check for empty or null fields
    return clientData.values.any((value) => value == null || value.isEmpty);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).colorScheme.primaryContainer,
      body: Form(
        key: _formKey,
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 30.0),
          child: Column(
            children: [
              const SizedBox(height: 100),
              Text(
                "Client Information",
                style: Theme.of(context).textTheme.headlineLarge,
              ),
              Text(
                  'Welcome, ${widget.username}! Token: ${widget.token}, User ID: ${widget.userId}'),
              const SizedBox(height: 35),
              _buildTextField(_controllerName, "First Name", "Please enter your first name"),
              const SizedBox(height: 10),
              _buildTextField(_controllerMiddleName, "Middle Name", null),
              const SizedBox(height: 10),
              _buildTextField(_controllerLastName, "Last Name", "Please enter your last name"),
              const SizedBox(height: 10),
              _buildGenderDropdown(),
              const SizedBox(height: 10),
              _buildTextField(_controllerAddress, "Address", null),
              const SizedBox(height: 10),
              _buildTextField(_controllerContactNumber, "Contact Number", "Please enter your contact number"),
              const SizedBox(height: 50),
              ElevatedButton(
                style: ElevatedButton.styleFrom(
                  minimumSize: const Size.fromHeight(50),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(20),
                  ),
                ),
                onPressed: _submitClientData,
                child: const Text("Submit"),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildTextField(
      TextEditingController controller, String label, String? errorText) {
    return TextFormField(
      controller: controller,
      decoration: InputDecoration(
        labelText: label,
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
        ),
      ),
      validator: (value) => (value == null || value.isEmpty) && errorText != null
          ? errorText
          : null,
    );
  }

  Widget _buildGenderDropdown() {
    return DropdownButtonFormField<String>(
      value: _selectedGender,
      decoration: InputDecoration(
        labelText: "Gender",
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
        ),
      ),
      items: ['Male', 'Female', 'Other'].map((gender) {
        return DropdownMenuItem(
          value: gender,
          child: Text(gender),
        );
      }).toList(),
      onChanged: (value) {
        setState(() {
          _selectedGender = value;
        });
      },
      validator: (value) => value == null ? 'Please select your gender' : null,
    );
  }

  Future<void> _submitClientData() async {
  if (_formKey.currentState?.validate() ?? false) {
    // Print values for debugging
    print('Submitting with:');
    print('First Name: ${_controllerName.text}');
    print('Middle Name: ${_controllerMiddleName.text}');
    print('Last Name: ${_controllerLastName.text}');
    print('Gender: $_selectedGender');
    print('Address: ${_controllerAddress.text}');
    print('Contact Number: ${_controllerContactNumber.text}');
    print('User ID: ${widget.userId}');
    print('Token: $storedToken');

    // Collect client data for API call
    final clientData = {
      'username': widget.username,
      'name': _controllerName.text,
      'middlename': _controllerMiddleName.text,
      'lastname': _controllerLastName.text,
      'gender': _selectedGender,
      'address': _controllerAddress.text,
      'contact_number': _controllerContactNumber.text,
      'user_id': widget.userId,
      'token': storedToken,
    };
    

    try {
      // Make the API call
      await updateClientInfo(clientData, widget.token, widget.userId);
      // Assuming the function doesn't return anything, handle success by navigating or updating the UI
      print('Client data updated successfully');
      // Navigate to the Home page or perform other actions
      Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => Home(clientData: json.encode(clientData), username: '',),  // Pass the data to Home
      ),
    );

    } catch (e) {
      _showErrorSnackBar("Failed to update client info: $e");
      print('Error: $e');
    }
  }
}


  void _clearFormFields() {
    _controllerName.clear();
    _controllerMiddleName.clear();
    _controllerLastName.clear();
    _controllerAddress.clear();
    _controllerContactNumber.clear();
  }

  void _showErrorSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(message)));
  }

  @override
  void dispose() {
    _clearFormFields();
    super.dispose();
  }
}
