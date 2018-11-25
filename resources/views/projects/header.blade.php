<div class="deployment-overview d-flex align-items-center">
    <div class="project">
        <span>PROJECT</span>
        <h2 class="pt-1 pb-0">{{ $project->name }}</h2>

        <div class="skewed-border"></div>
    </div><!-- /.project -->

    <div class="environment">
        <span>ENVIRONMENT</span>
        <h2 class="pt-1 pb-0">Master</h2>
    </div><!-- /.environment -->

    <div class="start-deployment">
        @if ($project->servers)
            <start-deployment :project-id="{{ $project->id }}"></start-deployment>
        @else
            <div class="alert alert-warning mt-3" role="alert">
                Add a server to start a new deployment.
            </div><!-- /.alert -->
        @endif
    </div><!-- /.start-deployment -->
</div><!-- /.deployment-overview -->
