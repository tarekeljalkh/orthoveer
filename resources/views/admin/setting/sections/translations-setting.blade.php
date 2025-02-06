<div class="tab-pane fade" id="translations-setting" role="tabpanel" aria-labelledby="translations-tab">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.translations-setting.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Tab Navigation for English and French -->
                <ul class="nav nav-pills" id="translationsTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="english-tab" data-toggle="pill" href="#english-translations"
                            role="tab" aria-controls="english-translations" aria-selected="true">English</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="french-tab" data-toggle="pill" href="#french-translations"
                            role="tab" aria-controls="french-translations" aria-selected="false">French</a>
                    </li>
                </ul>

                <div class="tab-content" id="translationsTabContent">
                    <!-- English Tab Content -->
                    <div class="tab-pane fade show active" id="english-translations" role="tabpanel"
                        aria-labelledby="english-tab">
                        <div class="row">
                            @foreach ($englishTranslations as $key => $value)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <label for="en_{{ $key }}">{{ ucfirst(str_replace('_', ' ', $key)) }}</label> --}}
                                        <label
                                            for="en_{{ $key }}">{{ $key }}</label>
                                        <input name="translations[en][{{ $key }}]" type="text"
                                            class="form-control" value="{{ $value }}"
                                            id="en_{{ $key }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- French Tab Content -->
                    <div class="tab-pane fade" id="french-translations" role="tabpanel" aria-labelledby="french-tab">
                        <div class="row">
                            @foreach ($frenchTranslations as $key => $value)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fr_{{ $key }}">{{ $key }}</label>
                                        <input name="translations[fr][{{ $key }}]" type="text"
                                            class="form-control" value="{{ $value }}"
                                            id="fr_{{ $key }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Translations</button>
            </form>
        </div>
    </div>
</div>
