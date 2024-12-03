class Property {
  final int id;
  final String name;
  final String address;
  final String city;
  final String status;

  Property({ 
    required this.id, 
    required this.name,
    required this.address, 
    required this.city,
    required this.status,
  });

  factory Property.fromJson(Map<String, dynamic> json) {
    return Property(
      id: json['id'],
      name: json['name'],
      address: json['address'],
      city: json['city'],
      status: json['status'],
    );
  }
}

class Room {
  final String roomCode;
  final double rentAmount;  // Keep it as int if you want to round the rent value
  final String status;

  Room({required this.roomCode, required this.rentAmount, required this.status});

  factory Room.fromJson(Map<String, dynamic> json) {
    return Room(
      roomCode: json['room_code'],
      rentAmount: double.tryParse(json['rent_amount'].toString()) ?? 0.0, // Convert to int
      status: json['status'],
    );
  }
}