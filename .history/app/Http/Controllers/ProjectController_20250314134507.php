<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    protected $projectRepository;
    protected $artisanProfileRepository;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        ArtisanProfileRepositoryInterface $artisanProfileRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->artisanProfileRepository = $artisanProfileRepository;
    }

    public function index()
    {
        $userId = Auth::id();
        $projects = $this->projectRepository->findByUserId($userId);

        return view('projects.index', compact('projects'));
    }

    public function show($id)
    {
        $project = $this->projectRepository->find($id);

        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Project not found.');
        }

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date|after:today',
        ]);

        $data['user_id'] = Auth::id();
        $project = $this->projectRepository->create($data);

        return redirect()->route('projects.show', $project->id)->with('success', 'Project created successfully.');
    }

    public function edit($id)
    {
        $project = $this->projectRepository->find($id);

        if (!$project || $project->user_id !== Auth::id()) {
            return redirect()->route('projects.index')->with('error', 'You are not authorized to edit this project.');
        }

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = $this->projectRepository->find($id);

        if (!$project || $project->user_id !== Auth::id()) {
            return redirect()->route('projects.index')->with('error', 'You are not authorized to edit this project.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date|after:today',
        ]);

        $this->projectRepository->update($id, $data);

        return redirect()->route('projects.show', $id)->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $project = $this->projectRepository->find($id);

        if (!$project || $project->user_id !== Auth::id()) {
            return redirect()->route('projects.index')->with('error', 'You are not authorized to delete this project.');
        }

        $this->projectRepository->delete($id);

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
