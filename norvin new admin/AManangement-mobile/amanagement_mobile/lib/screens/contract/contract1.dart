import 'dart:convert';
import 'package:amanagement_mobile/screens/contract/contract2.dart';
import 'package:flutter/material.dart';
import '../../models/room.dart';
import '../../utils/https.dart';

class Contract1 extends StatefulWidget {
  final int userId;
  final String email;
  final String name;
  final String token;

  Contract1({
    required this.token,
    required this.userId,
    required this.email,
    required this.name,
  });

  @override
  PropertyRoomSelectionScreenState createState() =>
      PropertyRoomSelectionScreenState();
}

class PropertyRoomSelectionScreenState extends State<Contract1> {
  List<Property> properties  = [];
  List<Room> rooms = [];

  
  bool isLoading = true;
  int? selectedPropertyId;

  @override
  void initState() {
    super.initState();
    fetchProperties(widget.token);
  }

  // Fetch properties
  Future<void> fetchProperties(String token) async {
    setState(() {
      isLoading = true;
    });

    try {
      final properties = await ApiService().fetchProperties(token);
      print(properties);
      if (properties != null) {
        setState(() {
          this.properties = properties;
          isLoading = false;
        });
      }
    } catch (error) {
      setState(() {
        isLoading = false;
      });
      // Handle error here, show a message to the user if necessary
    }
  }

  // Fetch rooms based on selected property
  Future<void> fetchRoomsByProperty(int propertyId, String token) async {
    setState(() {
      isLoading = true;
    });

    try {
      final rooms = await ApiService().fetchRoomsByProperty(propertyId, token);
      // print(rooms);
      if (rooms != null) {
        setState(() {
          this.rooms = rooms;
          isLoading = false;
        });
      }
    } catch (error) {
      setState(() {
        isLoading = false;
      });
      // Handle error here, show a message to the user if necessary
    }
  }



  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(

        title: Text("Select Property and Room"),
        backgroundColor: Colors.blueAccent,
      ),
      body: isLoading
          ? Center(
              child: CircularProgressIndicator(
                valueColor: AlwaysStoppedAnimation<Color>(Colors.blueAccent),
              ),
            )
          : Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                children: [
                  // Dropdown for properties
                  Container(
                    padding: EdgeInsets.symmetric(vertical: 10),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(8),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black12,
                          offset: Offset(0, 2),
                          blurRadius: 5,
                        ),
                      ],
                    ),
                    child: DropdownButton<int>(
                      hint: Text('Select Property'),
                      value: selectedPropertyId,
                      onChanged: (int? newValue) {
                        setState(() {
                          selectedPropertyId = newValue;
                        });
                        // Fetch rooms for the selected property
                        if (newValue != null) {
                          fetchRoomsByProperty(newValue, widget.token);
                        }
                      },
                      isExpanded: true, // Makes the dropdown button expand
                      items: properties
                          .map((property) => DropdownMenuItem<int>(
                                value: property.id,
                                child: Padding(
                                  padding: const EdgeInsets.all(8.0),
                                  child: Text(
                                    '${property.address} - ${property.city}',
                                    style: TextStyle(
                                      fontSize: 16,
                                      fontWeight: FontWeight.w500,
                                    ),
                                  ),
                                ),
                              ))
                          .toList(),
                    ),
                  ),
                  SizedBox(height: 20),
                  // List of rooms with better styling
                  if (rooms.isNotEmpty)
                    Expanded(
                      child: Container( // Set the background color to white
                        child: ListView.builder(
                          itemCount: rooms.length,
                          itemBuilder: (context, index) {
                            Room room = rooms[index];  // Get the current room
                            print('Room Code: ${room.roomCode}, Rent Amount: ${room.rentAmount}');
                            return Card(
                              color: Colors.white,
                              elevation: 5,
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(12),
                              ),
                              margin: EdgeInsets.symmetric(vertical: 8),
                              child: ListTile(
                                contentPadding: EdgeInsets.all(16),
                                leading: Icon(
                                  Icons.room,
                                  color: Colors.blueAccent,
                                  size: 32,
                                ),
                                title: Text(
                                  "Room ${room.roomCode}",
                                  style: TextStyle(
                                    fontSize: 18,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                subtitle: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      "Rent: \$${room.rentAmount}",
                                      style: TextStyle(
                                        color: Colors.blue,
                                      ),
                                    ),
                                    Text(
                                      "Status: ${room.status}",
                                      style: TextStyle(
                                        color: room.status == 'rented' ? Colors.orange : Colors.green,
                                      ),
                                    ),
                                  ],
                                ),
                                onTap: () {
                                  if (selectedPropertyId != null) {
                                    print(selectedPropertyId);
                                    navigateToContract2(selectedPropertyId!, room.roomCode, room.rentAmount);
                                  }
                                },
                              ),
                            );
                          }

                        ),
                      ),
                    ),
                ],
              ),
            ),
    );
  }

  void navigateToContract2(int propertyId, String roomCode, double rentAmount) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => Contract2(
          token: widget.token,
          userId: widget.userId,
          email: widget.email,
          name: widget.name,
          propertyId: propertyId, // Convert to String if required
          roomCode: roomCode,
          rentAmount: rentAmount,
        ),
      ),
    );
  }

}
