import 'package:amanagement_flutter/utils/sharedpreferenceservice.dart';
import 'package:flutter/material.dart';
import '../utils/httpmethods.dart'; // Assuming API method
import '../pages/home.dart';

class ClientDataSignup extends StatefulWidget {
  final String username;
  final String token;
  final int userId;

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

  final SharedPreferencesService _prefsService = SharedPreferencesService();


  bool hasNullValues() {
    return _controllerName.text.isEmpty ||
        _controllerMiddleName.text.isEmpty ||
        _controllerLastName.text.isEmpty ||
        _controllerAddress.text.isEmpty ||
        _controllerContactNumber.text.isEmpty ||
        _selectedGender == null;
  }

  void _submitClientData() async {
    if (_formKey.currentState?.validate() ?? false) {
      try {
        Map<String, dynamic> clientData = {
          'name': _controllerName.text,
          'middlename': _controllerMiddleName.text,
          'lastname': _controllerLastName.text,
          'gender': _selectedGender,
          'address': _controllerAddress.text,
          'contact_number': _controllerContactNumber.text,
        };

        final response = await updateClientInfo(clientData, widget.token, widget.userId);

        if (response.message == 'Client information updated successfully') {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Client data submitted successfully!')),
          );

          await _prefsService.saveUserDataToPrefs(widget.token, response.userInfo, response.clientInfo);

          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (context) => Home(
                userId: widget.userId,
                token: widget.token,
                userInfo: response.userInfo,
                clientInfo: response.clientInfo,
              ),
            ),
          );
        } else {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Error: ${response.message}')),
          );
        }
      } catch (e) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Error: $e')),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Client Data Signup"),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: ListView(
            children: [
              _buildTextField("First Name", _controllerName),
              _buildTextField("Middle Name", _controllerMiddleName),
              _buildTextField("Last Name", _controllerLastName),
              _buildGenderDropdown(),
              _buildTextField("Address", _controllerAddress),
              _buildTextField("Contact Number", _controllerContactNumber),
              const SizedBox(height: 20),
              ElevatedButton(
                onPressed: _submitClientData,
                child: const Text("Submit"),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildTextField(String label, TextEditingController controller) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 10.0),
      child: TextFormField(
        controller: controller,
        decoration: InputDecoration(
          labelText: label,
          border: OutlineInputBorder(),
        ),
        validator: (value) {
          if (value == null || value.isEmpty) {
            return "Please enter $label.";
          }
          return null;
        },
      ),
    );
  }

  Widget _buildGenderDropdown() {
    return Padding(
      padding: const EdgeInsets.only(bottom: 10.0),
      child: DropdownButtonFormField<String>(
        value: _selectedGender,
        hint: const Text("Select Gender"),
        items: ['Male', 'Female', 'Other']
            .map((gender) => DropdownMenuItem<String>(
                  value: gender,
                  child: Text(gender),
                ))
            .toList(),
        onChanged: (value) {
          setState(() {
            _selectedGender = value;
          });
        },
        decoration: InputDecoration(
          labelText: "Gender",
          border: OutlineInputBorder(),
        ),
        validator: (value) {
          if (value == null) {
            return "Please select gender.";
          }
          return null;
        },
      ),
    );
  }
}
