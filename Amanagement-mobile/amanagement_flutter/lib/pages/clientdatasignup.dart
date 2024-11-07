// import 'dart:ffi';

import 'package:flutter/material.dart';
// import 'package:hive_flutter/hive_flutter.dart';
// import 'package:http/http.dart';
import 'dart:convert';
import '../utils/httpmethods.dart'; // Assumed API method
import '../pages/home.dart';
// import '../model/authmodels/auth_response.dart';

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

  bool hasNullValues() {
    return
      _controllerName.text.isEmpty ||
      _controllerMiddleName.text.isEmpty ||
      _controllerLastName.text.isEmpty ||
      _controllerAddress.text.isEmpty ||
      _controllerContactNumber.text.isEmpty ||
      _selectedGender == null;
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
        items: ['Male', 'Female', 'Other']
            .map((gender) => DropdownMenuItem(
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
          if (value == null || value.isEmpty) {
            return "Please select gender.";
          }
          return null;
        },
      ),
    );
  }

  void _submitClientData() async {
    print(widget.userId);
  if (_formKey.currentState?.validate() ?? false) {
    if (hasNullValues()) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Please fill in all the fields.')),
      );
      return;
    }

   try {
    print('Initial widget.userId: ${widget.userId}');  // Debugging line

    // int userId = int.tryParse(widget.userId ?? '') ?? 0;
    // print('Parsed int userId: $userId');  // Debugging line

    final response = await updateClientInfo(
      {
        'first_name': _controllerName.text,
        'middle_name': _controllerMiddleName.text,
        'last_name': _controllerLastName.text,
        'gender': _selectedGender,
        'address': _controllerAddress.text,
        'contact_number': _controllerContactNumber.text,
      },
      widget.token,
widget.userId,
      // userId,
    );
    print("client data response: $response");
        Map<String, dynamic> clientData = {
        'client_info': {
          'name': _controllerName.text.isEmpty ? "" : _controllerName.text,  // Fallback to empty string if null
          'middlename': _controllerMiddleName.text.isEmpty ? "" : _controllerMiddleName.text,
          'lastname': _controllerLastName.text.isEmpty ? "" : _controllerLastName.text,
          'gender': _selectedGender ?? "",  // Fallback to empty string if null
          'address': _controllerAddress.text.isEmpty ? "" : _controllerAddress.text,
          'contact_number': _controllerContactNumber.text.isEmpty ? "" : _controllerContactNumber.text,
        },
        'token': widget.token,
        
      };

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Client data submitted successfully!')),
      );
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (context) => Home(userId: widget.userId, clientData: '',),
        ),
      );
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error: $e')),
      );
    }
  }
}

// void _submitClientData() async {
//   if (_formKey.currentState?.validate() ?? false) {
//     if (hasNullValues()) {
//       ScaffoldMessenger.of(context).showSnackBar(
//         const SnackBar(content: Text('Please fill in all the fields.')),
//       );
//       return;
//     }

//     try {
//       // Get the userId from the response (ensure it's not null)
//       int userId = responseData['data']['client_info']['user_id'] ?? 0;
      
//       if (userId == 0) {
//         // Handle the case where userId is 0 (or handle null case accordingly)
//         ScaffoldMessenger.of(context).showSnackBar(
//           const SnackBar(content: Text('Error: Invalid user ID')),
//         );
//         return;
//       }

//       final response = await updateClientInfo(
//         {
//           'first_name': _controllerName.text,
//           'middle_name': _controllerMiddleName.text,
//           'last_name': _controllerLastName.text,
//           'gender': _selectedGender,
//           'address': _controllerAddress.text,
//           'contact_number': _controllerContactNumber.text.toString(),
//         },
//         widget.token,
//         userId,
//       );

//       Map<String, dynamic> clientData = {
//         'client_info': {
//           'name': _controllerName.text.isEmpty ? "" : _controllerName.text,
//           'middlename': _controllerMiddleName.text.isEmpty ? "" : _controllerMiddleName.text,
//           'lastname': _controllerLastName.text.isEmpty ? "" : _controllerLastName.text,
//           'gender': _selectedGender ?? "",
//           'address': _controllerAddress.text.isEmpty ? "" : _controllerAddress.text,
//           'contact_number': _controllerContactNumber.text.isEmpty ? "" : _controllerContactNumber.text,
//         },
//         'token': widget.token,
//       };

//       ScaffoldMessenger.of(context).showSnackBar(
//         const SnackBar(content: Text('Client data submitted successfully!')),
//       );
//       Navigator.pushReplacement(
//         context,
//         MaterialPageRoute(
//           builder: (context) => Home(clientData: json.encode(clientData)),
//         ),
//       );
//     } catch (e) {
//       ScaffoldMessenger.of(context).showSnackBar(
//         SnackBar(content: Text('Error: $e')),
//       );
//     }
//   }
// }


}
