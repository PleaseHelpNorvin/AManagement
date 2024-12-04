import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import '../../screens/home.dart';

class ContractListScreen extends StatefulWidget {
  final String token;
  final int userId;
  final String email;
  final String name;

  ContractListScreen({
    required this.token,
    required this.userId,
    required this.email,
    required this.name,
  });

  @override
  _ContractListScreenState createState() => _ContractListScreenState();
}

class _ContractListScreenState extends State<ContractListScreen> {
  bool isLoading = true;
  String errorMessage = '';
  List<dynamic> contracts = []; // Store the fetched contract data

  @override
  void initState() {
    super.initState();
    print("ContractListScreen initialized");

    // Fetch contract data
    _fetchContractData();
  }

  Future<void> _fetchContractData() async {
    try {
      final response = await http.get(
        Uri.parse('http://127.0.0.1:8000/api/tenant/contracts/'),
        headers: {
          'Authorization': 'Bearer ${widget.token}',
        },
      );
      
      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        setState(() {
          contracts = responseData['data']; // Save the contract data
          isLoading = false;
        });
      } else {
        setState(() {
          isLoading = false;
          errorMessage = 'Failed to load contracts';
        });
      }
    } catch (e) {
      setState(() {
        isLoading = false;
        errorMessage = 'Error: $e';
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    // Print the received data to confirm it's being passed correctly
    print('Token: ${widget.token}');
    print('User ID: ${widget.userId}');
    print('Email: ${widget.email}');
    print('Name: ${widget.name}');

    if (isLoading) {
      return Scaffold(
        body: Center(child: CircularProgressIndicator()),
      );
    }

    if (errorMessage.isNotEmpty) {
      return Scaffold(
        body: Center(child: Text(errorMessage)),
      );
    }

    return Scaffold(
      body: ListView.builder(
        itemCount: contracts.length,
        itemBuilder: (context, index) {
          final contract = contracts[index];
          return Card(
            elevation: 4,
            margin: EdgeInsets.symmetric(vertical: 10, horizontal: 16),
            child: ListTile(
              title: Text('Contract ${contract['id']}'),
              subtitle: Text('Details of contract'),
              onTap: () {
                // Navigate to contract details screen
              },
            ),
          );
        },
      ),
    );
  }
}
