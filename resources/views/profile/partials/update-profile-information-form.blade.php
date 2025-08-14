<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Perbarui informasi profil akun Anda.') }}
        </p>
    </header>


    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Email (readonly) -->
        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')" class="form-label" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full form-control bg-gray-100"
                :value="old('email', $user->email)" readonly />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Name -->
        <div class="mt-3">
            <x-input-label for="name" :value="__('Name')" class="form-label" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full form-control"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Tempat Lahir -->
        <div class="mt-3">
            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" class="form-label" />
            <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full form-control"
                :value="old('tempat_lahir', $user->tempat_lahir)" />
            <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
        </div>

        <!-- Tanggal Lahir -->
        <div class="mt-3">
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" class="form-label" />
            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full form-control"
                :value="old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '')" />
            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
        </div>

        <!-- NIP -->
        <div class="mt-3">
            <x-input-label for="nip" :value="__('NIP')" class="form-label" />
            <x-text-input id="nip" name="nip" type="text" class="mt-1 block w-full form-control"
                :value="old('nip', $user->nip)" />
            <x-input-error class="mt-2" :messages="$errors->get('nip')" />
        </div>

        <!-- NIDN -->
        <div class="mt-3">
            <x-input-label for="nidn" :value="__('NIDN')" class="form-label" />
            <x-text-input id="nidn" name="nidn" type="text" class="mt-1 block w-full form-control"
                :value="old('nidn', $user->nidn)" />
            <x-input-error class="mt-2" :messages="$errors->get('nidn')" />
        </div>


        <!-- Jabatan -->
        <div class="mt-3">
            <x-input-label for="jabatan" :value="__('Jabatan')" class="form-label" />
            <select id="jabatan" name="jabatan" class="mt-1 block w-full form-control">
                <option value="">-- Pilih Jabatan --</option>
                @foreach ($jabatans as $jabatan)
                    <option value="{{ $jabatan->nama_jabatan }}"
                        {{ old('jabatan', $user->jabatan) == $jabatan->nama_jabatan ? 'selected' : '' }}>
                        {{ $jabatan->nama_jabatan }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('jabatan')" />
        </div>

        <!-- Pangkat -->
        <div class="mt-3">
            <x-input-label for="pangkat" :value="__('Pangkat')" class="form-label" />
            <select id="pangkat" name="pangkat" class="mt-1 block w-full form-control">
                <option value="">-- Pilih Pangkat --</option>
                @foreach ($pangkats as $pangkat)
                    @php
                        $pangkatValue = $pangkat->nama_pangkat . ' ' . $pangkat->golongan;
                    @endphp
                    <option value="{{ $pangkatValue }}"
                        {{ old('pangkat', $user->pangkat) == $pangkatValue ? 'selected' : '' }}>
                        {{ $pangkatValue }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('pangkat')" />
        </div>


        <!-- Photo -->
        <div class="mt-3">
            <x-input-label for="photos" :value="__('Profile Photo')" class="form-label" />
            <input id="photos" name="photos" type="file" class="mt-1 block w-full form-control" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('photos')" />

            <div class="mt-2">
                @if (!empty($user->photos) && file_exists(public_path('storage/avatars/'.$user->photos)))
                    <img src="{{ asset('storage/avatars/'.$user->photos) }}"
                        alt="Profile Photo"
                        style="width:100px; height:100px;"
                        class="rounded-full object-cover">
                @endif
            </div>

        </div>

        <div class="flex items-center gap-4 mt-3">
            <x-primary-button class="btn btn-primary mt-2">{{ __('Save') }}</x-primary-button>


        </div>
    </form>
</section>
