import 'dart:convert';

class ContractResponse {
  final bool success;
  final String message;
  final List<Contract> data;

  ContractResponse({
    required this.success,
    required this.message,
    required this.data,
  });

  // Factory method to parse JSON into a ContractResponse object
  factory ContractResponse.fromJson(Map<String, dynamic> json) {
    return ContractResponse(
      success: json['success'],
      message: json['message'],
      data: List<Contract>.from(json['data'].map((x) => Contract.fromJson(x))),
    );
  }

  // Method to convert ContractResponse to JSON
  Map<String, dynamic> toJson() {
    return {
      'success': success,
      'message': message,
      'data': List<dynamic>.from(data.map((x) => x.toJson())),
    };
  }
}

class Contract {
  final int id;
  final int tenantId;
  final int propertyId;
  final String contractCode;
  final String rentAmount;
  final String lateFee;
  final String securityDepositAmount;
  final DateTime contractDate;
  final DateTime startDate;
  final DateTime endDate;
  final int noticePeriod;
  final String status;
  final String paymentDueDay;
  final DateTime createdAt;
  final DateTime updatedAt;
  final Tenant tenant;
  final Property property;

  Contract({
    required this.id,
    required this.tenantId,
    required this.propertyId,
    required this.contractCode,
    required this.rentAmount,
    required this.lateFee,
    required this.securityDepositAmount,
    required this.contractDate,
    required this.startDate,
    required this.endDate,
    required this.noticePeriod,
    required this.status,
    required this.paymentDueDay,
    required this.createdAt,
    required this.updatedAt,
    required this.tenant,
    required this.property,
  });

  // Factory method to parse JSON into a Contract object
  factory Contract.fromJson(Map<String, dynamic> json) {
    return Contract(
      id: json['id'],
      tenantId: json['tenant_id'],
      propertyId: json['property_id'],
      contractCode: json['contract_code'],
      rentAmount: json['rent_amount'],
      lateFee: json['late_fee'],
      securityDepositAmount: json['security_deposit_amount'],
      contractDate: DateTime.parse(json['contract_date']),
      startDate: DateTime.parse(json['start_date']),
      endDate: DateTime.parse(json['end_date']),
      noticePeriod: json['notice_period'],
      status: json['status'],
      paymentDueDay: json['payment_due_day'],
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
      tenant: Tenant.fromJson(json['tenant']),
      property: Property.fromJson(json['property']),
    );
  }

  // Method to convert Contract to JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'tenant_id': tenantId,
      'property_id': propertyId,
      'contract_code': contractCode,
      'rent_amount': rentAmount,
      'late_fee': lateFee,
      'security_deposit_amount': securityDepositAmount,
      'contract_date': contractDate.toIso8601String(),
      'start_date': startDate.toIso8601String(),
      'end_date': endDate.toIso8601String(),
      'notice_period': noticePeriod,
      'status': status,
      'payment_due_day': paymentDueDay,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
      'tenant': tenant.toJson(),
      'property': property.toJson(),
    };
  }
}

class Tenant {
  final int id;
  final String name;
  final String email;
  final String? emailVerifiedAt;
  final String role;
  final DateTime createdAt;
  final DateTime updatedAt;

  Tenant({
    required this.id,
    required this.name,
    required this.email,
    this.emailVerifiedAt,
    required this.role,
    required this.createdAt,
    required this.updatedAt,
  });

  // Factory method to parse JSON into a Tenant object
  factory Tenant.fromJson(Map<String, dynamic> json) {
    return Tenant(
      id: json['id'],
      name: json['name'],
      email: json['email'],
      emailVerifiedAt: json['email_verified_at'],
      role: json['role'],
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
    );
  }

  // Method to convert Tenant to JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'email_verified_at': emailVerifiedAt,
      'role': role,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
    };
  }
}

class Property {
  final int id;
  final int ownerId;
  final String name;
  final String address;
  final String city;
  final String postalCode;
  final String type;
  final String status;
  final DateTime createdAt;
  final DateTime updatedAt;

  Property({
    required this.id,
    required this.ownerId,
    required this.name,
    required this.address,
    required this.city,
    required this.postalCode,
    required this.type,
    required this.status,
    required this.createdAt,
    required this.updatedAt,
  });

  // Factory method to parse JSON into a Property object
  factory Property.fromJson(Map<String, dynamic> json) {
    return Property(
      id: json['id'],
      ownerId: json['owner_id'],
      name: json['name'],
      address: json['address'],
      city: json['city'],
      postalCode: json['postal_code'],
      type: json['type'],
      status: json['status'],
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
    );
  }

  // Method to convert Property to JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'owner_id': ownerId,
      'name': name,
      'address': address,
      'city': city,
      'postal_code': postalCode,
      'type': type,
      'status': status,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
    };
  }
}
