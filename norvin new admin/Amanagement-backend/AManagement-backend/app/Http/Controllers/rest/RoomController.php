<?php

namespace App\Http\Controllers\rest;

use App\Models\Room;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class RoomController extends ApiController
{
    //
    public function showRoomsByPropertyId($property_id)
    {
        // Retrieve all rooms that match the given property_id and have an available or rented status
        $rooms = Room::where('property_id', $property_id)
                    ->whereIn('status', ['available', 'rented']) // Check for both 'available' and 'rented' statuses
                    ->get();

        // Check if rooms exist for the given property_id
        if ($rooms->isEmpty()) {
            return $this->errorResponse('No rooms found for this property', 404);
        }

        return $this->successResponse($rooms, 'Rooms Fetched Successfully');
    }



    public function showProperties()
    {
        // Retrieve all properties related to rooms, without the room details.
        $properties = Property::get();

        return $this->successResponse($properties, 'Properties Fetched Successfully');
    }
}
