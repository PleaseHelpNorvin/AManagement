class ProfileResponse {
  final bool success;
  final String message;
  final int id;
  final int userId;
  final String phoneNumber;
  final String address;
  final String? profilePictureUrl;
  final String emergencyContact;
  final String? bio; // Bio is a file, but we will store the URL of the file here
  final String createdAt;
  final String updatedAt;

  ProfileResponse({
    required this.success,
    required this.message,
    required this.id,
    required this.userId,
    required this.phoneNumber,
    required this.address,
    this.profilePictureUrl,
    required this.emergencyContact,
    this.bio,
    required this.createdAt,
    required this.updatedAt,
  });

  // Factory method to create ProfileResponse instance from JSON
    factory ProfileResponse.fromJson(Map<String, dynamic> json) {
      return ProfileResponse(
        success: json['success'] ?? false, // Default to false if null
        message: json['message'] ?? '', // Default to an empty string if null
        id: json['data']['id'],
        userId: json['data']['user_id'],
        phoneNumber: json['data']['phone_number'],
        address: json['data']['address'],
        profilePictureUrl: json['data']['profile_picture_url'],
        emergencyContact: json['data']['emergency_contact'],
        bio: json['data']['bio'],
        createdAt: json['data']['created_at'],
        updatedAt: json['data']['updated_at'],
      );
  }

  // Convert ProfileResponse instance to JSON
  Map<String, dynamic> toJson() {
    return {
      'success': success,
      'message': message,
      'id': id,
      'user_id': userId,
      'phone_number': phoneNumber,
      'address': address,
      'profile_picture_url': profilePictureUrl,
      'emergency_contact': emergencyContact,
      'bio': bio,
      'created_at': createdAt,
      'updated_at': updatedAt,
    };
  }
}
