class ClientInfo {
  final int id;
  final int userId;
  final String name;
  final String middlename;
  final String lastname;
  final String gender;
  final String address;
  final String contactNumber;
  final String createdAt;
  final String updatedAt;

  ClientInfo({
    required this.id,
    required this.userId,
    this.name = '',
    this.middlename = '',
    this.lastname = '',
    this.gender = '',
    this.address = '',
    this.contactNumber = '',
    required this.createdAt,
    required this.updatedAt,
  });

  factory ClientInfo.fromJson(Map<String, dynamic> json) {
    return ClientInfo(
      id: json['id'] ?? 0, // Default to 0 if 'id' is null
      userId: json['user_id'] ?? 0, // Ensure userId is not null, default to 0
      name: json['name'] ?? '', // Default to empty string if 'name' is null
      middlename: json['middlename'] ?? '',
      lastname: json['lastname'] ?? '',
      gender: json['gender'] ?? '',
      address: json['address'] ?? '',
      contactNumber: json['contact_number'] ?? '',
      createdAt: json['created_at'] ?? '', // Could be DateTime instead of String
      updatedAt: json['updated_at'] ?? '', // Could be DateTime instead of String
    );
  }

  // Optional: If you want to convert the object to JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'user_id': userId,
      'name': name,
      'middlename': middlename,
      'lastname': lastname,
      'gender': gender,
      'address': address,
      'contact_number': contactNumber,
      'created_at': createdAt,
      'updated_at': updatedAt,
    };
  }
}
