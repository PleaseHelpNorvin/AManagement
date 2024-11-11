class RegisterResponse {
  final String token;
  final String role;
  // final bool isLoggedIn;
  final String message;
  final UserInfo userInfo;
  final ClientInfo clientInfo;

  RegisterResponse({
    required this.token,
    required this.role,
    // required this.isLoggedIn,
    required this.message,
    required this.userInfo,
    required this.clientInfo,
  });

  // Factory method to parse the JSON response into a RegisterResponse object
  factory RegisterResponse.fromJson(Map<String, dynamic> json) {
    return RegisterResponse(
      token: json['data']['token'],
      role: json['data']['role'], 
      // isLoggedIn: json['data']['is_logged_in'],
      message: json['message'],
      userInfo: UserInfo.fromJson(json['data']['user_info']),
      clientInfo: ClientInfo.fromJson(json['data']['client_info']),
    );
  }
}

class LoginResponse {
  final String token;
  final String role;
  final String message;
  final UserInfo userInfo;
  final ClientInfo clientInfo;

  LoginResponse({
    required this.token,
    required this.role,
    required this.message,
    required this.userInfo,
    required this.clientInfo,
  });

  // Factory method to parse the JSON response into a RegisterResponse object
  factory LoginResponse.fromJson(Map<String, dynamic> json) {
    return LoginResponse(
      token: json['data']['token'],
      role: json['data']['role'], 
      message: json['message'],
      userInfo: UserInfo.fromJson(json['data']['user_info']),
      clientInfo: ClientInfo.fromJson(json['data']['client_info']),
    );
  }

}

class UserInfo {
  final int id;
  final String username;
  final String email;
  final String createdAt;
  final String updatedAt;
  final bool isLoggedIn;

  UserInfo({
    required this.id,
    required this.username,
    required this.email,
    required this.createdAt,
    required this.updatedAt,
    required this.isLoggedIn,
  });

  // Factory method to parse user info from JSON
  factory UserInfo.fromJson(Map<String, dynamic> json) {
    return UserInfo(
      id: json['id'],
      username: json['username'],
      email: json['email'],
      createdAt: json['created_at'],
      updatedAt: json['updated_at'],
      isLoggedIn: json['is_logged_in'],
    );
  }
}

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
    required this.name,
    required this.middlename,
    required this.lastname,
    required this.gender,
    required this.address,
    required this.contactNumber,
    required this.createdAt,
    required this.updatedAt,
  });

  // Factory method to parse client info from JSON
  factory ClientInfo.fromJson(Map<String, dynamic> json) {
    return ClientInfo(
      id: json['id'],
      userId: json['user_id'],
      name: json['name'],
      middlename: json['middlename'],
      lastname: json['lastname'],
      gender: json['gender'],
      address: json['address'],
      contactNumber: json['contact_number'],
      createdAt: json['created_at'],
      updatedAt: json['updated_at'],
    );
  }
}
