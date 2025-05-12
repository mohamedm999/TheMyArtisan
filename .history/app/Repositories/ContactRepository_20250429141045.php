<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ContactRepository implements ContactRepositoryInterface
{
    /**
     * Store a contact form submission
     *
     * @param array $data
     * @return bool
     */
    public function storeContactMessage(array $data): bool
    {
        try {
            Contact::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'is_read' => false,
                'ip_address' => $data['ip_address'] ?? request()->ip(),
                'user_agent' => $data['user_agent'] ?? request()->userAgent()
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error storing contact message', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return false;
        }
    }
    
    /**
     * Get all contact form submissions with pagination
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllContactMessages(int $perPage = 10)
    {
        return Contact::orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    /**
     * Get a contact message by ID
     *
     * @param int $id
     * @return mixed
     */
    public function getContactMessageById(int $id)
    {
        return Contact::find($id);
    }
    
    /**
     * Mark a contact message as read
     *
     * @param int $id
     * @return bool
     */
    public function markAsRead(int $id): bool
    {
        try {
            $contact = Contact::find($id);
            if (!$contact) {
                return false;
            }
            
            $contact->is_read = true;
            $contact->save();
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error marking contact message as read', [
                'error' => $e->getMessage(),
                'id' => $id
            ]);
            return false;
        }
    }
    
    /**
     * Delete a contact message
     *
     * @param int $id
     * @return bool
     */
    public function deleteContactMessage(int $id): bool
    {
        try {
            $contact = Contact::find($id);
            if (!$contact) {
                return false;
            }
            
            $contact->delete();
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting contact message', [
                'error' => $e->getMessage(),
                'id' => $id
            ]);
            return false;
        }
    }
}