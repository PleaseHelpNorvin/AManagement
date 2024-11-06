import 'dart:convert';

class ClientInfo {
  final String name;
  final String? middlename;
  final String lastname;
  final String gender;
  final String address;
  final String contactNumber;

  ClientInfo({
    required this.name,
    this.middlename,
    required this.lastname,
    required this.gender,
    required this.address,
    required this.contactNumber,
  });

  // Factory method to create a ClientInfo object from a JSON map
  factory ClientInfo.fromJson(Map<String, dynamic> json) {
    return ClientInfo(
      name: json['name'] ?? '',
      middlename: json['middlename'],
      lastname: json['lastname'] ?? '',
      gender: json['gender'] ?? '',
      address: json['address'] ?? '',
      contactNumber: json['contact_number'] ?? '',
    );
  }

  // Method to convert ClientInfo to a Map (useful for encoding)
  Map<String, dynamic> toJson() {
    return {
      'name': name,
      'middlename': middlename,
      'lastname': lastname,
      'gender': gender,
      'address': address,
      'contact_number': contactNumber,
    };
  }
}

class ClientData {
  final String token;
  final String role;
  final int userId;
  final ClientInfo clientInfo;

  ClientData({
    required this.token,
    required this.role,
    required this.userId,
    required this.clientInfo,
  });

  // Factory method to create a ClientData object from a JSON map
  factory ClientData.fromJson(Map<String, dynamic> json) {
    return ClientData(
      token: json['token'] ?? '',
      role: json['role'] ?? '',
      userId: json['user_id'] ?? 0,
      clientInfo: ClientInfo.fromJson(json['client_info'] ?? {}),
    );
  }

  // Method to convert ClientData to a Map (useful for encoding)
  Map<String, dynamic> toJson() {
    return {
      'token': token,
      'role': role,
      'user_id': userId,
      'client_info': clientInfo.toJson(),
    };
  }
}
