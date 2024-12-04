import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import '../../screens/home.dart';
import '../../components/appbar&bottomnavbar.dart';

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
  List<dynamic> contracts = [];

  @override
  void initState() {
    super.initState();
    _fetchContractData();
  }

  Future<void> _fetchContractData() async {
    try {
      final response = await http.get(
        Uri.parse('http://127.0.0.1:8000/api/tenant/contracts/${widget.userId}'),
        headers: {
          'Authorization': 'Bearer ${widget.token}',
        },
      );
      print(response);

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        setState(() {
          contracts = responseData['data'];
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
    return CommonScaffold(
      selectedIndex: 1, // Set this to the index of the "Contracts" tab
      appBarTitle: 'Contract List',
      onItemTapped: (index) {
        if (index == 0) {
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (context) => HomeScreen(
                token: widget.token,
                userId: widget.userId,
                email: widget.email,
                name: widget.name,
              ),
            ),
          );
        }
        // Handle other navigation cases
      },
      body: isLoading
          ? Center(child: CircularProgressIndicator())
          : Column(
              children: [
                Padding(
                  padding: const EdgeInsets.all(16.0), // Add some padding
                  child: ElevatedButton(
                    onPressed: () {
                      // Add your button functionality here
                      _fetchContractData(); // For example, refresh the contract list
                    },
                    child: const Text('Make Contract'),
                  ),
                ),
                Expanded(
                  child: errorMessage.isNotEmpty
                      ? Center(child: Text(errorMessage))
                      : ListView.builder(
                          itemCount: contracts.length,
                          itemBuilder: (context, index) {
                            final contract = contracts[index];
                            return Card(
                              elevation: 4,
                              margin: const EdgeInsets.symmetric(
                                  vertical: 10, horizontal: 16),
                              child: ListTile(
                                title: Text('Contract ${contract['id']}'),
                                subtitle: const Text('Details of contract'),
                                onTap: () {
                                  // Navigate to contract details screen
                                },
                              ),
                            );
                          },
                        ),
                ),
              ],
            ),
    );
  }
}
